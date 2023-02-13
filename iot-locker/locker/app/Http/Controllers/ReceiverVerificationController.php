<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Helpers\SMS;
use App\Events\SmsEvent;
use App\Helpers\EventLog;
use App\Helpers\ValidateNumber;
use App\Models\Booking;
use App\Models\Box;
use App\Models\Location;
use App\Models\Message;
use Carbon\Carbon;
use Exception;

class ReceiverVerificationController extends Controller
{
    private $LocalLocationData;

    function __construct()
    {
        $this->LocalLocationData = Location::first();
    }

    public function verificationForm()
    {
        if (!isset($this->LocalLocationData)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'The system is not configured yet');
        }

        return view('verification-form');
    }

    public function verificationFormSubmit(Request $request)
    {
        $request->validate(
            [
                'receiver_mobile_no' => 'required|string|digits:11'
            ],
            [
                'receiver_mobile_no.required' => __('verification.validation.receiver_mobile_no.required'),
                'receiver_mobile_no.digits' => __('verification.validation.receiver_mobile_no.digits')
            ]
        );

        $numberValidation = ValidateNumber::validateNumber($request->receiver_mobile_no);
        $numberValidation = json_decode($numberValidation->getContent());

        if ($numberValidation->code != 200) {
            return redirect()
                ->back()
                ->withInput()
                // ->with('error', $numberValidation->reason);
                ->with('error', __('verification.error-message.contact_no'));
        }

        $request->receiver_mobile_no = $numberValidation->formatted_number;

        $parcelInfo = Booking::where('booking_receiver_mobile_no', $request->receiver_mobile_no)
            ->where('booking_is_synced', 0)
            ->whereNull('booking_collected_by')
            ->get();


        if (count($parcelInfo) < 1) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('verification.error-message.mobile-no'));
        }

        Session::put('receiver_mobile_no', $request->receiver_mobile_no);

        return redirect()->route('verify-receiver-info');
    }

    public function verificationBarcodeFormSubmit(Request $request)
    {
        $request->validate(
            [
                'barcode' => 'required'
            ],
            [
                'barcode.required' => __('verification.validation.barcode.required')
            ]
        );

        $booking = Booking::where('booking_id', $request->barcode)
            ->whereNotNull('booking_receiver_otp')
            ->first();

        if (!isset($booking)) {
            return redirect()
                ->route('verification')
                ->with('error', __('verification.error-message.parcel-not-found'));
        }

        // if ($booking->is_max_pickup_time_passed == 1) {
        //     return redirect()
        //         ->back()
        //         ->withInput()
        //         ->with('error', __('verification.error-message.collection'));
        // }

        if ($booking->box->box_is_enable == 0) {
            return redirect()->route('verification')->with('error', '' . $booking->box->box_no . ' is Disable for some reason');
        }

        Session::put('using_barcode', 1);
        Session::put('booking_id', $booking->booking_id);
        return redirect()->route('verify-company-otp');
    }

    public function verifyReceiverInfo()
    {
        if (Session::get('using_barcode')) {
            return redirect()->route('slider-page');
        }

        $bookings = Booking::where('booking_receiver_mobile_no', Session::get('receiver_mobile_no'))
            ->where('booking_is_synced', 0)
            ->whereNull('booking_collected_by')
            ->get();

        if (count($bookings) < 1) {
            Session::forget('receiver_mobile_no');
            return redirect()->route('slider-page');
        }

        return view('verify-with-parcel', ['bookings' => $bookings]);
    }

    public function verifyWithParcelSubmit(Request $request)
    {
        $request->validate(
            [
                'iotLocker_otp' => 'required|digits:4',
                'company_otp' => 'required|digits:6'
            ],
            [
                'iotLocker_otp.required' => __('verify-with-parcel.validation.iotLocker_otp.required', ['digit' => '4']),
                'company_otp.required' => __('verify-with-parcel.validation.company_otp.required'),
                'iotLocker_otp.digits' => __('verify-with-parcel.validation.iotLocker_otp.digits'),
                'company_otp.digits' => __('verify-with-parcel.validation.company_otp.digits', ['digit' => '6']),
            ]
        );

        $booking = Booking::where('booking_id', $request->booking_id)
            ->first();

        if (!isset($booking)) {
            return redirect()->route('verification');
        }

        if ($booking->booking_receiver_otp != $request->iotLocker_otp) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('verify-with-parcel.error-message.iotLocker_otp'));
        }

        // if ($booking->is_max_pickup_time_passed == 1) {
        //     return redirect()
        //         ->back()
        //         ->withInput()
        //         ->with('error', 'Collection time has expired.');
        // }

        if ($booking->box->box_is_enable == 0) {
            return redirect()->route('verification')->with('error', '' . $booking->box->box_no . ' is Disable for some reason');
        }

        Session::put('company_otp', $request->company_otp);

        return view('parcel-receiving-counter', ['booking' => $booking]);
    }

    public function verifyCompanyOTP()
    {
        $booking = Booking::where('booking_id', Session::get('booking_id'))
            ->first();

        if (!isset($booking)) {
            return redirect()->route('verification');
        }

        if ($booking->box->box_is_enable == 0) {
            return redirect()->route('verification')->with('error', '' . $booking->box->box_no . ' is Disable for some reason');
        }

        return view('verify-company-otp', ['booking' => $booking]);
    }

    public function verifyCompanyOTPSubmit(Request $request)
    {
        $request->validate([
            'company_otp' => 'required'
        ]);

        if (strlen($request->company_otp) != 6) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Invalid OTP');
        }

        Session::put('company_otp', $request->company_otp);

        $booking = Booking::where('booking_id', Session::get('booking_id'))
            ->first();

        if (!isset($booking)) {
            return redirect()->route('verification');
        }

        if ($booking->box->box_is_enable == 0) {
            return redirect()->route('verification')->with('error', '' . $booking->box->box_no . ' is Disable for some reason');
        }

        return view('parcel-receiving-counter', ['booking' => $booking]);
    }

    public function receiverPickupConfirmed(Request $request)
    {
        $booking = Booking::find($request->booking_id);

        if (isset($booking)) {
            try {
                $booking_update_flag = $booking->update([
                    'booking_receiver_otp' => null,
                    'booking_company_otp' => Session::get('company_otp'),
                    'booking_collected_by' => $booking->booking_receiver_mobile_no,
                    'booking_collected_at' => Carbon::now()->format('Y-m-d-H:i:s')
                ]);

                $box_update_flag = $booking->box->update([
                    'box_is_booked' => 0,
                    'box_is_closed' => 0,
                    'box_booking_id' => null
                ]);

                if (isset($box_update_flag)) {
                    EventLog::BoxOpen($booking->box);
                }

                if ($booking_update_flag && $box_update_flag) {
                    EventLog::ParcelCollected($booking);

                    return true;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function thankYouMsg(Request $request)
    {
        $booking = Booking::find($request->booking_id);

        if (isset($booking)) {
            try {

                $box_update_flag = $booking->box->update([
                    'box_is_closed' => 1
                ]);

                if (isset($box_update_flag)) {
                    EventLog::BoxClose($booking->box);

                    try {

                        $smsBody = 'Parcel ID: ' . $booking->booking_parcel_no . ' successfully collected by ' . $booking->booking_receiver_mobile_no . '. Thank you for using iotLocker';
                        $smsInput['sms_location_id'] = $this->LocalLocationData->location_id;
                        $smsInput['sms_key'] = $this->LocalLocationData->location_id . '-' . Str::random(4);
                        $smsInput['sms_event_type'] = 'pickup confirmed';
                        $smsInput['sms_receiver_number'] = $booking->booking_receiver_mobile_no;
                        $smsInput['sms_text'] = $smsBody;

                        $msgResponse = Message::create($smsInput);
                        if ($msgResponse) {
                            event(new SmsEvent($msgResponse));
                        }

                        Session::forget('company_otp');
                        Session::forget('booking_id');

                        return true;
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function informCustomerAndSupervisor(Request $request)
    {
        $booking = Booking::find($request->booking_id);

        if ($booking->box->box_is_enable == 0) {
            return redirect()->route('deliveryman.box-booking')->with('error', '' . $booking->box->box_no . ' is Disable for some reason');
        }

        try {
            $sms2CustomerBody = $booking->box->box_no . ' detected NOT CLOSED PROPERLY at location: ' . $this->LocalLocationData->location_address . ' Please close the box properly or the incident will be reported. iotLocker';

            $sms2Customer['sms_location_id'] = $this->LocalLocationData->location_id;
            $sms2Customer['sms_key'] = $this->LocalLocationData->location_id . '-' . Str::random(4);
            $sms2Customer['sms_event_type'] = 'box-open-alert';
            $sms2Customer['sms_receiver_number'] = $booking->booking_receiver_mobile_no;
            $sms2Customer['sms_text'] = $sms2CustomerBody;

            $msgCustomerResponse = Message::create($sms2Customer);

            $sms2SupervisorBody = $booking->box->box_no . '  detected NOT CLOSED PROPERLY at location: ' . $this->LocalLocationData->location_address . ' by customer ' . $booking->booking_receiver_mobile_no . ', Parcel_ID:' . $booking->booking_parcel_no . ' iotLocker';

            $sms2Supervisor['sms_location_id'] = $this->LocalLocationData->location_id;
            $sms2Supervisor['sms_key'] = $this->LocalLocationData->location_id . '-' . Str::random(4);
            $sms2Supervisor['sms_event_type'] = 'box-open-alert';
            $sms2Supervisor['sms_receiver_number'] = env('SUPERVISOR_MOBILE_NUMBER');
            $sms2Supervisor['sms_text'] = $sms2SupervisorBody;

            $msgSupervisorResponse = Message::create($sms2Supervisor);

            if ($msgCustomerResponse && $msgSupervisorResponse) {
                event(new SmsEvent($msgCustomerResponse));

                $booking->update(['booking_receiver_otp' => null]);
                $booking->box->update([
                    // 'box_is_enable' => 0,
                    'box_is_in_maintenance' => 1,
                    'box_is_closed' => 0
                ]);

                Session::forget('receiver_mobile_no');
                Session::forget('company_otp');
                Session::forget('booking_id');

                EventLog::BoxMaintenanceFromCustomer($booking);
                return true;
            } else {
                return 'failed';
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //Instant Verification OTP is not used now
    public function verificationOTP(Request $request)
    {
        return view('verification-otp');
    }

    public function verificationOTPSubmit(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $parcelInfo = Booking::where('booking_receiver_otp', '=', $request->otp)->first();

        if (!isset($parcelInfo)) {
            return redirect()->route('verification-otp')
                ->with('error', 'The OTP is not match. Please try again with actual OTP.');
        }

        $parcelInfo->update(['booking_receiver_otp' => null]);

        return redirect()->route('counter', [
            'booking_id' => $parcelInfo->id
        ]);
    }
}
