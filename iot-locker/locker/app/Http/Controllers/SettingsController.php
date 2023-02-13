<?php

namespace App\Http\Controllers;

use App\Helpers\Encryption;
use App\Models\GeneralSetting;
use App\Models\Location;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SettingsController extends Controller
{
    private $LocalLocationData;

    function __construct()
    {
        $this->LocalLocationData = Location::first();
    }

    public function LocationSettings()
    {
        if (!isset($this->LocalLocationData)) {
            return view('settings');
        }
        return view('dashboard', ['location' => $this->LocalLocationData]);
    }

    public function LocationSettingsSubmit(Request $request)
    {
        if (isset($this->LocalLocationData)) {
            return view('dashboard', ['location' => $this->LocalLocationData]);
        }

        $request->validate(
            [
                'locker_id' => 'required',
                'h_client_name' => 'required',
                'h_client_secret' => 'required',
            ],
            [
                'h_client_name.required' => 'The Client Name is required.',
                'h_client_secret.required' => 'The Client Secret is required.',
            ]
        );

        $inputLocation['location_id'] = $request->locker_id;
        $inputLocation['location_address'] = $request->location_address;
        $inputLocation['location_landmark'] = $request->location_landmark;

        $inputGS['setting_location_id'] = $request->locker_id;
        $inputGS['setting_name'] = 'client_info';
        $inputGS['setting_value'] = json_encode(
            [
                "locker_id" => $request->locker_id,
                "client_name" => $request->h_client_name,
                "client_secret" => $request->h_client_secret
            ]
        );

        try {
            $response = Location::create($inputLocation);
            if ($response) {
                try {
                    $generalSettings = GeneralSetting::latest()->first();

                    if (isset($generalSettings)) {
                        $generalSettings->update($inputGS);
                        return redirect()->route('dashboard')->with('success', 'Initial setup complete Successfully');
                    } else {
                        $gsResponse = GeneralSetting::create($inputGS);

                        if ($gsResponse) {
                            return redirect()->route('dashboard')->with('success', 'Initial setup complete Successfully');
                        } else {
                            return redirect()->route('settings.location')
                                ->with('error', 'Location isn\'t setup properly..!');
                        }
                    }
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } else {
                return redirect()->route('settings.location')
                    ->with('error', 'Location isn\'t setup properly..!');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
