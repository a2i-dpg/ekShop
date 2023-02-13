<?php

namespace App\Http\Controllers\DeliveryMan;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\ConnectionException;

use App\Events\BoxBookingEvent;
use App\Events\SmsEvent;
use App\Helpers\BarcodeLinkGenerator;
use App\Helpers\EventLog;
use App\Helpers\ValidateNumber;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Location;
use App\Models\Box;
use App\Models\Booking;
use App\Models\Message;
use App\Models\User;
use Exception;

class BoxBookingController extends Controller
{
    private $LocalLocationData;

    function __construct()
    {
        $this->LocalLocationData = Location::first();
    }

    public function index()
    {
        Session::forget('box_size');
        Session::forget('selected_flag');

        $booking = Booking::where('is_max_pickup_time_passed', 1)
            ->where('booking_collected_by', '=', null)
            // ->where('booking_assigned_person_to_return', auth()->user()->user_id)
            ->get();

        if (count($booking) > 0 && Session::get('skip_returned_list') == false) {
            return redirect()->route('deliveryman.box-booking-return');
        }

        $emergency_boxlist = Box::where('emergency_box_open', 1)
            // ->where('box_is_in_maintenance', 1)
            // ->where('box_is_enable', 0)
            // ->where('box_is_booked', 0)
            ->orderBy(DB::raw('LENGTH(box_no), box_no'))
            ->get();

        if (count($emergency_boxlist) > 0 && Session::get('skip_emergencyboxopen_list') == false) {
            return redirect()->route('deliveryman.emergency_box_open');
        }

        $boxes = Box::orderBy(DB::raw('LENGTH(box_no), box_no'))->get();
        return view('deliveryman.box-booking.index', ['boxes' => $boxes]);
    }

    public function sizeWiseBoxList(Request $request)
    {
        Session::forget('selected_flag');
        Session::put('box_size', $request->box_size);
        $boxes = Box::where('box_size', '=', $request->box_size)
            ->orderBy(DB::raw('LENGTH(box_no), box_no'))
            ->get();

        return view(
            'deliveryman.box-booking.size-wise-boxlist',
            [
                'boxes' => $boxes,
                'box_size' => $request->box_size
            ]
        );
    }

    public function legendWiseBoxList(Request $request)
    {
        Session::put('selected_flag', $request->flag);
        $flag = $request->flag;

        $query = DB::table('boxes');
        if (Session::has('box_size')) {
            $query->where('box_size', '=', Session::get('box_size'));
        }

        if ($flag == 'booked') {
            $query->where('box_is_booked', '=', 1);
        }

        if ($flag == 'available') {
            $query->where('box_is_booked', '=', 0);
            $query->where('box_is_in_maintenance', '=', 0);
        }

        if ($flag == 'maintenance') {
            $query->where('box_is_in_maintenance', '=', 1);
        }

        $query->orderBy(DB::raw('LENGTH(box_no), box_no'));
        $boxes = $query->get();

        return view(
            'deliveryman.box-booking.size-wise-boxlist',
            [
                'boxes' => $boxes,
                'box_size' => $request->box_size
            ]
        );
    }

    public function boxBooking(Request $request)
    {
        $box = Box::find($request->box_id);

        if ($box->box_is_enable == 0) {
            return redirect()->route('deliveryman.boxlist')->with('error', '' . $box->box_no . ' is Disable for some reason');
        }

        if ($box->box_is_booked == 1) {
            return redirect()->route('deliveryman.boxlist')->with('error', '' . $box->box_no . ' is already booked');
        }

        return view('deliveryman.box-booking.box-booking', ['box' => $box]);
    }

    public function boxBookingSubmit(Request $request)
    {
        if (Auth::user()->role_id === 6) {
            $request->validate(
                [
                    'receiver_mobile_no' => 'required|digits:11',
                    'parcel_no' => 'required'
                ],
                [
                    'parcel_no.required' => __('box-booking-deliveryman.validation.parcel_no.required'),
                    'receiver_mobile_no.required' => __('box-booking-deliveryman.validation.receiver_mobile_no.required'),
                    'receiver_mobile_no.digits' => __('box-booking-deliveryman.validation.receiver_mobile_no.digits')
                ]
            );

            $numberValidation = ValidateNumber::validateNumber($request->receiver_mobile_no);
            $numberValidation = json_decode($numberValidation->getContent());

            if ($numberValidation->code != 200) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', __('box-booking-deliveryman.error-message.receiver_mobile_no'));
            }

            if (strlen($numberValidation->formatted_number) < 11) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', __('box-booking-deliveryman.error-message.receiver_mobile_no'));
            }

            $request->receiver_mobile_no = $numberValidation->formatted_number;
            Session::put('receiver_mobile_no', $request->receiver_mobile_no);
        } else {
            $request->validate(
                [
                    'parcel_no' => 'required'
                ],
                [
                    'parcel_no.required' => __('box-booking-deliveryman.validation.parcel_no.required'),
                ]
            );
        }

        $booking = Booking::where('booking_parcel_no', $request->parcel_no)
            ->where('booking_is_synced', 0)
            ->whereNull('booking_collected_by')
            ->whereNull('booking_collected_at')
            ->get();

        if (count($booking) > 0) {
            return redirect()->route('deliveryman.boxlist')->with('error', __('box-booking-deliveryman.error-message.parcel_booked'));
        }

        Session::put('box_id', $request->box_id);
        Session::put('parcel_no', $request->parcel_no);

        return redirect()->route('deliveryman.box-booking-counter');
    }

    public function boxBookingCounter()
    {
        $box = Box::find(Session::get('box_id'));

        if ($box->box_is_enable == 0) {
            return redirect()->route('deliveryman.box-booking')->with('error', '' . $box->box_no . ' is Disable for some reason');
        }

        return view('deliveryman.box-booking.box-booking-counter', ['box' => $box]);
    }

    public function bookingConfirmed(Request $request)
    {
        $box = Box::find($request->box_id);
        $otp = mt_rand(1000, 9999);

        $input['booking_id'] = $this->LocalLocationData->location_id . '-' . Session::get('parcel_no') . '-' . strtoupper(Str::random(6));
        $input['booking_box_id'] = $box->id;
        $input['booking_box_key'] = $box->box_key;
        $input['booking_location_id'] = $this->LocalLocationData->location_id;
        if (Auth::user()->role_id === 6) {
            $input['booking_receiver_mobile_no'] = Session::get('receiver_mobile_no');
        }
        $input['booking_parcel_no'] = Session::get('parcel_no');
        $input['booking_receiver_otp'] = $otp;
        $input['booking_parcel_company_id'] = auth()->user()->company_id;
        $input['booking_booked_by'] = auth()->user()->user_id;
        $input['booking_booked_at'] = Carbon::now()->format('Y-m-d-H:i:s');

        $shortLinkUrl = BarcodeLinkGenerator::GRcode($input['booking_id']);
        $input['booking_barcode_url'] = $shortLinkUrl;

        try {
            $bookingResponse = Booking::create($input);

            if ($bookingResponse) {
                $box = Box::find($request->box_id);

                $updateResponse = $box->update([
                    'box_is_booked' => 1,
                    'box_is_closed' => 1,
                    'box_booking_id' => $bookingResponse->booking_id
                ]);

                if (isset($updateResponse)) {
                    EventLog::BoxClose($box);
                }
                $bookingInfo = Booking::with('box')->find($bookingResponse->id);

                EventLog::Booking($bookingInfo);

                // event(new BoxBookingEvent($bookingResponse)); // Box and Booking isn't sync same time

                Session::forget('box_id');
                Session::forget('parcel_no');
                Session::forget('receiver_mobile_no');

                return true;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function bookingCancel(Request $request)
    {
        return redirect()->route('deliveryman.boxlist')->with('success', 'Booking canceled');
    }

    public function informDeliveryMan(Request $request)
    {
        $box = Box::find($request->box_id);

        if ($box->box_is_enable == 0) {
            return redirect()->route('deliveryman.boxlist')->with('error', '' . $box->box_no . ' is Disable for some reason');
        }

        try {
            $smsBody = $box->box_no . ' detected NOT CLOSED PROPERLY at location: ' . $this->LocalLocationData->location_address . '. Please close the box properly or the incident will be reported. iotLocker';

            $sms2DeliveryMan['sms_location_id'] = $this->LocalLocationData->location_id;
            $sms2DeliveryMan['sms_key'] = $this->LocalLocationData->location_id . '-' . Str::random(4);
            $sms2DeliveryMan['sms_event_type'] = 'box-open-alert';
            $sms2DeliveryMan['sms_receiver_number'] = auth()->user()->contact_no;
            $sms2DeliveryMan['sms_text'] = $smsBody;

            $msgResponse = Message::create($sms2DeliveryMan);

            if ($msgResponse) {
                event(new SmsEvent($msgResponse));
                Session::forget('box_id');
                Session::forget('receiver_mobile_no');
                Session::forget('parcel_no');

                $boxInfo = $box->update([
                    // 'box_is_enable' => 0,
                    'box_is_in_maintenance' => 1,
                    'box_is_closed' => 0
                ]);

                EventLog::BoxMaintenanceFromDeliveryMan($box);
                return true;
            } else {
                return 'failed';
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
