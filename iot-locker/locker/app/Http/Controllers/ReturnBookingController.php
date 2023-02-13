<?php

namespace App\Http\Controllers;

use App\Events\SmsEvent;
use App\Helpers\EventLog;
use App\Models\Booking;
use App\Models\Box;
use App\Models\Location;
use App\Models\Message;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReturnBookingController extends Controller
{
    private $LocalLocationData;

    function __construct()
    {
        $this->LocalLocationData = Location::first();
    }

    public function boxBookingReturn()
    {
        $booking = Booking::where('is_max_pickup_time_passed', 1)
            ->where('booking_collected_by', '=', null)
            // ->where('booking_assigned_person_to_return', auth()->user()->user_id)
            ->get();

        if (count($booking) < 1) {
            return redirect()->route('deliveryman.boxlist');
        }

        return view('deliveryman.box-booking.box-booking-return', ['booking' => $booking]);
    }

    public function boxBookingReturnSubmit(Request $request)
    {
        $booking = Booking::find($request->booking_id);

        if ($booking->box->box_is_enable == 0) {
            return redirect()->route('deliveryman.box-booking-return')->with('error', '' . $booking->box->box_no . ' is Disable for some reason');
        }

        return view('deliveryman.box-booking.box-booking-return-counter', ['booking' => $booking]);
    }

    public function deliveryManPickupConfirmed(Request $request)
    {
        $booking = Booking::find($request->booking_id);

        if (isset($booking)) {
            try {
                $booking_update_flag = $booking->update([
                    'booking_receiver_otp' => null,
                    'booking_is_returned' => 1,
                    'booking_collected_by' =>  auth()->user()->user_id,
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
                    EventLog::ParcelReturned($booking);

                    $smsBody = 'Due to the expiry of 72 hours, iotLocker has initiated the return of your parcel: ' . $booking->booking_parcel_no . ', and can no longer be collected from iotLocker.';

                    $smsInput['sms_location_id'] = $this->LocalLocationData->location_id;
                    $smsInput['sms_key'] = $this->LocalLocationData->location_id . '-' . Str::random(4);
                    $smsInput['sms_event_type'] = 'notification';
                    $smsInput['sms_receiver_number'] = $booking->booking_receiver_mobile_no;
                    $smsInput['sms_text'] = $smsBody;

                    $msgResponse = Message::create($smsInput);

                    if (isset($msgResponse)) {
                        event(new SmsEvent($msgResponse));
                    }

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
            EventLog::BoxClose($booking->box);

            try {
                $box_update_flag = $booking->box->update([
                    'box_is_closed' => 1
                ]);

                if ($box_update_flag) {
                    return true;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function informReturnDeliveryMan(Request $request)
    {
        $box = Box::find($request->box_id);

        if ($box->box_is_enable == 0) {
            return redirect()->route('deliveryman.boxlist')->with('error', '' . $box->box_no . ' is Disable for some reason');
        }

        try {
            $smsBody = $box->box_no . ' isn\'t close yet. Kindly close the box.';

            $sms2DeliveryMan['sms_location_id'] = $this->LocalLocationData->location_id;
            $sms2DeliveryMan['sms_key'] = $this->LocalLocationData->location_id . '-' . Str::random(4);
            $sms2DeliveryMan['sms_event_type'] = 'box-open-alert';
            $sms2DeliveryMan['sms_receiver_number'] = auth()->user()->contact_no;
            $sms2DeliveryMan['sms_text'] = $smsBody;

            $msgResponse = Message::create($sms2DeliveryMan);

            if ($msgResponse) {
                event(new SmsEvent($msgResponse));

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

    public function emergencyBoxOpen()
    {
        $emergency_boxlist = Box::where('emergency_box_open', 1)
            // ->where('box_is_in_maintenance', 1)
            // ->where('box_is_enable', 0)
            // ->where('box_is_booked', 0)
            ->orderBy(DB::raw('LENGTH(box_no), box_no'))
            ->get();

        if (count($emergency_boxlist) < 1) {
            return redirect()->route('deliveryman.boxlist');
        }

        return view('deliveryman.box-booking.emergency_box_open', ['emergency_boxlist' => $emergency_boxlist]);
    }

    public function emergencyBoxOpenSubmit(Request $request)
    {
        $box = Box::find($request->box_id);
        return view('deliveryman.box-booking.emergency_box_open-counter', ['box' => $box]);
    }

    public function incorrectPlacedParcelPickupConfirmed(Request $request)
    {
        $box = Box::find($request->box_id);

        if (!is_null($box->box_booking_id)) {

            $booking = Booking::where('booking_id', $box->box_booking_id)
                ->first();

            if (isset($booking)) {
                try {
                    $booking_update_flag = $booking->update([
                        'booking_receiver_otp' => null,
                        'booking_is_returned' => 1,
                        'booking_collected_by' =>  auth()->user()->user_id,
                        'booking_collected_at' => Carbon::now()->format('Y-m-d-H:i:s')
                    ]);

                    $box_update_flag = $booking->box->update([
                        'box_is_booked' => 0,
                        'box_is_closed' => 0,
                        'box_booking_id' => null,
                        'emergency_box_open' => 0
                    ]);

                    if (isset($box_update_flag)) {
                        EventLog::BoxOpen($booking->box);
                    }

                    if ($booking_update_flag && $box_update_flag) {
                        EventLog::incorrectPlacedParcelReceived($booking);
                    }

                    if (!is_null($booking->booking_receiver_mobile_no) && !is_null($booking->customer_sms_key)) {

                        $smsBody = 'Parcel ID: ' . $booking->booking_parcel_no . ' has been returned and can no longer be collected from iotLocker.';

                        $smsInput['sms_location_id'] = $this->LocalLocationData->location_id;
                        $smsInput['sms_key'] = $this->LocalLocationData->location_id . '-' . Str::random(4);
                        $smsInput['sms_event_type'] = 'notification';
                        $smsInput['sms_receiver_number'] = $booking->booking_receiver_mobile_no;
                        $smsInput['sms_text'] = $smsBody;

                        $msgResponse = Message::create($smsInput);

                        if (isset($msgResponse)) {
                            event(new SmsEvent($msgResponse));
                        }
                    }

                    return true;
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }
        } else {

            if (isset($box)) {
                try {
                    $box_update_flag = $box->update([
                        // 'box_is_enable' => 1,
                        // 'box_is_in_maintenance' => 0,
                        'box_is_closed' => 0,
                        'emergency_box_open' => 0
                    ]);

                    if (isset($box_update_flag)) {
                        EventLog::BoxOpen($box);
                    }

                    if ($box_update_flag) {
                        return true;
                    }
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }
        }
    }

    public function thankYouMsgForErrorPlacedParcel(Request $request)
    {
        $box = Box::find($request->box_id);

        if (isset($box)) {
            EventLog::BoxClose($box);

            try {
                $box_update_flag = $box->update([
                    'box_is_closed' => 1
                ]);

                if ($box_update_flag) {
                    return true;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function skipReturnedList(Request $request)
    {
        Session::put('skip_returned_list', 1);

        if (Session::get('skip_returned_list') == true) {
            return redirect()->route('deliveryman.boxlist');
        }
    }

    public function skipEmergencyBoxOpenList(Request $request)
    {
        Session::put('skip_emergencyboxopen_list', 1);

        if (Session::get('skip_emergencyboxopen_list') == true) {
            return redirect()->route('deliveryman.boxlist');
        }
    }
}
