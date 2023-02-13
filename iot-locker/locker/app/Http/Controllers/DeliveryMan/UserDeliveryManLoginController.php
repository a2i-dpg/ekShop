<?php

namespace App\Http\Controllers\DeliveryMan;

use App\Events\SmsEvent;
use App\Helpers\EventLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\SMS;
use App\Helpers\ValidateNumber;
use App\Models\Location;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserDeliveryManLoginController extends Controller
{
    private $LocalLocationData;

    function __construct()
    {
        $this->LocalLocationData = Location::first();
    }

    public function index()
    {
        if (!isset($this->LocalLocationData)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'The system is not configured yet');
        }

        return view('deliveryman.login');
    }

    public function loginFormSubmin(Request $request)
    {
        $login = $request->username;

        if (is_numeric($login)) {
            $field = 'contact_no';
        } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'username';
        }

        $request->merge([$field => $login]);

        // foreach ($request as $key => $value) {
        //     unset($request['username']);
        // }

        if (isset($request->email)) {
            $attr = $request->validate(
                [
                    'email' => 'required|string|email',
                    'password' => 'required|string|min:4'
                ],
                [
                    'email.required' => __('login-deliveryman.validation.email.required'),
                    'password.required' => __('login-deliveryman.validation.password.required'),
                    'password.min' => __('login-deliveryman.validation.password.min')
                ]
            );
        } elseif (isset($request->contact_no)) {
            $attr = $request->validate(
                [
                    // 'contact_no' => 'required|string|digits:11',
                    'password' => 'required|string|min:4'
                ],
                [
                    // 'contact_no.required' => __('login-deliveryman.validation.contact_no.required'),
                    'password.required' => __('login-deliveryman.validation.password.required'),
                    'password.min' => __('login-deliveryman.validation.password.min')
                ]
            );

            $numberValidation = ValidateNumber::validateNumber($request->contact_no);
            $numberValidation = json_decode($numberValidation->getContent());

            if ($numberValidation->code != 200) {
                return redirect()
                    ->back()
                    ->withInput()
                    // ->with('error', $numberValidation->reason);
                    ->with('error', __('login-deliveryman.error-message.contact_no'));
            }

            $attr['contact_no'] = $numberValidation->formatted_number;
        } else {
            $attr = $request->validate(
                [
                    'username' => 'required',
                    'password' => 'required|string|min:4'
                ],
                [
                    'username.required' => __('login-deliveryman.validation.username.required'),
                    'password.required' => __('login-deliveryman.validation.password.required'),
                    'password.min' => __('login-deliveryman.validation.password.min')
                ]
            );
        }

        if (!Auth::attempt($attr)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('login-deliveryman.error-message.credential'));
        }

        if (auth()->user()->role_id != 4 && auth()->user()->role_id != 6) {
            return redirect()->route('deliveryman.login')->with('error', __('boxlist-deliveryman.error-message.unauthorized'));
        }

        if (auth()->user()->is_active != 1) {
            return redirect()->route('deliveryman.login')->with('error', __('boxlist-deliveryman.error-message.user-not-active'));
        }

        EventLog::DeliveryManLogin();
        return redirect()->route('deliveryman.boxlist')->with('success', __('boxlist-deliveryman.success-message.login'));
    }

    public function alternativeLogin()
    {
        return view('deliveryman.alternative-login');
    }

    public function sendOTP(Request $request)
    {
        $request->validate(
            [
                'contact_no' => 'required'
            ],
            [
                'contact_no.required' => __('alternative-login-deliveryman.validation.contact_no.required'),
            ]
        );

        $numberValidation = ValidateNumber::validateNumber($request->contact_no);
        $numberValidation = json_decode($numberValidation->getContent());

        if ($numberValidation->code != 200) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('alternative-login-deliveryman.error-message.contact_no'));
        }

        $request->contact_no = $numberValidation->formatted_number;

        $userData = User::where('contact_no', '=', $request->contact_no)
            ->where('role_id', '=', 4)
            ->first();

        if (!isset($userData)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('alternative-login-deliveryman.error-message.credential'));
        }

        $otp = mt_rand(100000, 999999);
        $smsBody = 'Alternative login OTP: ' . $otp . ' for the rider ' . $userData->contact_no . ', Location: ' . $this->LocalLocationData->location_address . '. iotLocker';

        $smsInput['sms_location_id'] = $this->LocalLocationData->location_id;
        $smsInput['sms_key'] = $this->LocalLocationData->location_id . '-' . Str::random(4);
        $smsInput['sms_event_type'] = 'login otp';
        $smsInput['sms_receiver_number'] = $userData->contact_no;
        $smsInput['sms_text'] = $smsBody;

        $msgResponse = Message::create($smsInput);
        event(new SmsEvent($msgResponse));

        /*
        // This block is use when we want to send SMS without Queue and want to interactive with user

        $smsReturn = SMS::sendSms($userData->contact_no, $smsBody);

        if ($smsReturn->code != 200) {
            return redirect()->route('deliveryman.alternative-login')
                ->with('error', $smsReturn->reason);
        }
        */

        $userData->update(['otp' => $otp]);

        return redirect()
            ->route('deliveryman.send-otp', ['contact_no' => $request->contact_no])
            ->with('success', __('alternative-login-deliveryman.success-message.send-otp', ['contact_no' => $request->contact_no]));
    }

    public function sendOTPSubmitForm(Request $request)
    {
        return view('deliveryman.submit-otp', ['contact_no' => $request->contact_no]);
    }

    public function submitOTP(Request $request)
    {
        if (!isset($request->contact_no)) {
            return redirect()
                ->route('deliveryman.alternative-login')
                ->with('error', __('send-otp-deliveryman.error-message.contact_no'));
        }

        $request->validate(
            [
                'otp' => 'required'
            ],
            [
                'otp.required' => __('send-otp-deliveryman.validation.otp.required')
            ]
        );

        $attr = [
            'contact_no' => $request->contact_no,
            'otp' => $request->otp
        ];

        $userData = User::where('contact_no', '=', $request->contact_no)
            ->where('role_id', '=', 4)
            ->where('otp', '=', $request->otp)
            ->first();

        if (isset($userData)) {
            Auth::login($userData, true);
            $userData->update(['otp' => null]);

            return redirect()->route('deliveryman.boxlist')->with('success', __('send-otp-deliveryman.success-message.login'));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', __('send-otp-deliveryman.error-message.credential'));
    }
}
