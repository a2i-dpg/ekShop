<?php

namespace App\Http\Controllers;

use App\Events\SmsEvent;
use App\Helpers\EventLog;
use App\Models\Booking;
use App\Models\Box;
use App\Models\GeneralSetting;
use App\Models\Location;
use App\Models\Message;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OperationalController extends Controller
{
    private $LocalLocationData;

    function __construct()
    {
        $this->LocalLocationData = Location::first();
    }

    public function sliderPage(Request $request)
    {
        if (isset($this->LocalLocationData)) {
            // EventLog::Online();
        }

        // Session::flush();
        Session::forget('locale');

        Session::forget('receiver_mobile_no');
        Session::forget('using_barcode');

        try {
            $gs = GeneralSetting::where('setting_name', 'sliders')->first();
            $sliders = json_decode($gs->setting_value);
            return view('slider-page', ['sliders' => $sliders]);
        } catch (Exception $e) {
            return view('slider-page');
            // return $e->getMessage();
        }
    }

    public function offline()
    {
        if (Auth::check()) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        }
        // EventLog::Offline();

        return view('offline');
    }

    public function getAllBox(Request $request)
    {
        $boxes = Box::orderBy(DB::raw('LENGTH(box_no), box_no'))->get();
        return response()->json($boxes);
    }

    public function updateBoxIsClosed(Request $request)
    {
        $allBoxStatusArr = $request->all_box_status;
        $boxes = Box::orderBy(DB::raw('LENGTH(box_no), box_no'))->get();

        foreach ($boxes as $key => $box) {
            $booking_info = Booking::where('booking_box_id', $box->id)
                ->latest()
                ->first();

            if (isset($booking_info)) {

                if ($booking_info->booking_is_synced === 1) { // Customer block - Then we enable the box
                    if ($allBoxStatusArr[$key] === '1') {
                        if ($booking_info->box->box_is_enable === 1) {
                            Box::find($booking_info->box->id)->update([
                                // 'box_is_enable' => 1,
                                'box_is_in_maintenance' => 0,
                                'box_is_closed' => $allBoxStatusArr[$key]
                            ]);
                        } else {
                            Box::find($booking_info->box->id)->update([
                                'box_is_closed' => $allBoxStatusArr[$key]
                            ]);
                        }
                    } else {
                        Box::find($booking_info->box->id)->update([
                            'box_is_closed' => $allBoxStatusArr[$key]
                        ]);
                    }

                    $sms2SupervisorBody = $booking_info->box->box_no . ' has been detected closed at location:' . $this->LocalLocationData->location_address . ' iotLocker';

                    $sms2Supervisor['sms_location_id'] = $this->LocalLocationData->location_id;
                    $sms2Supervisor['sms_key'] = $this->LocalLocationData->location_id . '-' . Str::random(4);
                    $sms2Supervisor['sms_event_type'] = 'box-closing-info';
                    $sms2Supervisor['sms_receiver_number'] = env('SUPERVISOR_MOBILE_NUMBER');
                    $sms2Supervisor['sms_text'] = $sms2SupervisorBody;

                    // EventLog::BoxEnabledBySystem($booking_info->box);
                    // $msgSupervisorResponse = Message::create($sms2Supervisor);

                    // if ($msgSupervisorResponse) {
                    //     event(new SmsEvent($msgSupervisorResponse));
                    // }

                } else { // DeliveryMan block - Only update door close status

                    if ($allBoxStatusArr[$key] === '0') {
                        EventLog::parcelInDanger($booking_info);
                    } else {
                        Box::find($booking_info->box->id)->update([
                            'box_is_closed' => $allBoxStatusArr[$key]
                        ]);
                    }
                }
            } else {
                Box::find($box->id)->update([
                    'box_is_closed' => $allBoxStatusArr[$key]
                ]);
            }
        }
        return true;
    }

    public function updateSingleBoxOpenStatus(Request $request)
    {
        if (isset($request->box_id)) {
            $box = Box::find($request->box_id);

            $updateResponse = $box->update([
                'box_is_closed' => 0,
            ]);

            if (isset($updateResponse)) {
                EventLog::BoxOpen($box);
            }

            return true;
        }
    }

    public function informToSupervisor(Request $request)
    {
        $box = Box::find($request->box_id);

        try {
            $sms2SupervisorBody = $box->box_no . ' is Disable for some reason at location: ' . $this->LocalLocationData->location_address . '. iotLocker';

            $sms2Supervisor['sms_location_id'] = $this->LocalLocationData->location_id;
            $sms2Supervisor['sms_key'] = $this->LocalLocationData->location_id . '-' . Str::random(4);
            $sms2Supervisor['sms_event_type'] = 'box-maintenance-alert';
            $sms2Supervisor['sms_receiver_number'] = env('SUPERVISOR_MOBILE_NUMBER');
            $sms2Supervisor['sms_text'] = $sms2SupervisorBody;

            $msgSupervisorResponse = Message::create($sms2Supervisor);

            if ($msgSupervisorResponse) {
                event(new SmsEvent($msgSupervisorResponse));

                $box->update([
                    'box_is_enable' => 0,
                    'box_is_in_maintenance' => 1
                ]);

                EventLog::BoxMaintenanceFromSystem($box);
                return true;
            } else {
                return 'failed';
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function switchLanguage(Request $request)
    {
        Session::put('locale', $request->language);
        return true;
    }
}
