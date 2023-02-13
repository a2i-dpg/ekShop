<?php

namespace App\Http\Controllers;

use App\Events\SmsEvent;
use App\Models\Box;
use App\Models\Location;
use App\Models\Message;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminMaintenanceController extends Controller
{
    private $LocalLocationData;
    public function __construct()
    {
        $this->middleware('auth');
        $this->LocalLocationData = Location::first();
    }

    public function index()
    {
        $boxes = Box::orderBy(DB::raw('LENGTH(box_no), box_no'))->get();
        return view('admin.maintenance', ['boxes' => $boxes]);
    }

    public function getOtp()
    {
        $auth = User::find(Auth::id());
        $otp = mt_rand(100000, 999999);
        try {
            $smsBody = 'Dear Admin, Your iotLocker otp is ' . $otp;
            $smsInput['sms_location_id'] = $this->LocalLocationData->location_id;
            $smsInput['sms_key'] = $this->LocalLocationData->location_id . '-' . Str::random(4);
            $smsInput['sms_event_type'] = 'Admin OTP';
            $smsInput['sms_receiver_number'] = $auth->contact_no;
            $smsInput['sms_text'] = $smsBody;

            $msgResponse = Message::create($smsInput);
            if ($msgResponse) {
                event(new SmsEvent($msgResponse));
                $auth->otp_for_box = $otp;
                $auth->save();
                return response()->json([
                    'status' => '200',
                    'message' => "Otp send",
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => '200',
                'message' => $e->getMessage(),
            ]);
            // return $e->getMessage();
        }
    }

    public function checkOtp(Request $request)
    {
        $box_id = null;
        $auth = User::find(Auth::id());

        if ($auth->otp_for_box == $request->otp) {
            if ($request->check_for == "all") {
                $box_id = 1000;
            } elseif ($request->check_for == "settings_box") {
                $box_id = 48;
            } else {
                $box_id = $request->box_id;
            }

            return response()->json([
                'status' => '200',
                'box_id' => $box_id,
            ]);
        }
        return response()->json([
            'status' => '400',
            'box_id' => $box_id,
        ]);
    }
}
