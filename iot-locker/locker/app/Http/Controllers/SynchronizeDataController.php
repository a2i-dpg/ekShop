<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\Encryption;
use App\Helpers\HttpHeader;
use App\Models\User;
use App\Models\Box;
use App\Models\Booking;
use App\Models\Company;
use App\Models\EventLogModel;
use App\Models\Location;
use App\Models\GeneralSetting;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Storage;

class SynchronizeDataController extends Controller
{
    private $LocalLocationData;

    function __construct()
    {
        $this->LocalLocationData = Location::first();
    }

    public function index()
    {
        if (!isset($this->LocalLocationData)) {
            return redirect()->route('settings.location');
        }
        return view('synchronize-data', ['location' => $this->LocalLocationData]);
    }

    public function synchronizeCompanyData()
    {
        $DataSynchronizeCounter = 0;
        $resource = '/get-company';
        $apiEndpoint = env('API_BASE_URL') . env('API_VERSION') . $resource;

        try {
            $companies = Http::withHeaders(HttpHeader::pudoLocalHeader())
                ->get($apiEndpoint);

            if ($companies->successful()) {
                $companies = json_decode($companies);
                if ($companies->code != 200) {
                    return $companies->reason;
                }
                $companyData = json_decode(Encryption::apiDecryption($companies->data));

                foreach ($companyData as $company) {
                    $input['company_id'] = $company->company_id;
                    $input['company_name'] = $company->company_name;
                    $input['company_address'] = $company->company_address;
                    $input['company_contact_person_name'] = $company->company_contact_person_name;
                    $input['company_contact_person_number'] = $company->company_contact_person_number;
                    $input['company_email'] = $company->company_email;

                    $companyExist = Company::where('company_id', $company->company_id)->first();

                    if (!isset($companyExist)) {
                        $response = Company::create($input);
                        $DataSynchronizeCounter++;
                    } else {
                        if ($companyExist->updated_at != Carbon::parse($company->updated_at)) {
                            $companyExist->update($input);
                            $DataSynchronizeCounter++;
                        }
                    }
                }
                return redirect()->route('synchronize-data')->with('success', $DataSynchronizeCounter . ' Companies synchronized Successfully');
            } else {
                $companies = json_decode($companies);
                return back()->with('error', $companies->reason);
            }
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }

    public function synchronizeLocationData()
    {
        $DataSynchronizeCounter = 0;
        $resource = '/lockerInfo';
        $apiEndpoint = env('API_BASE_URL') . env('API_VERSION') . $resource;

        try {
            $locations = Http::withHeaders(HttpHeader::pudoLocalHeader())
                ->get($apiEndpoint, ['locker_id' => $this->LocalLocationData->location_id]);

            if ($locations->successful()) {
                $locations = json_decode($locations);

                if ($locations->code != 200) {
                    return $locations->reason;
                }
                $locationsData = json_decode(Encryption::apiDecryption($locations->data));

                foreach ($locationsData as $location) {
                    $input['location_id'] = $location->locker_id;
                    $input['location_address'] = $location->location_address;
                    $input['location_landmark'] = $location->location_landmark;
                    $input['is_active'] = $location->location_is_active;

                    $locationExist = Location::where('location_id', $location->locker_id)->first();

                    if (!isset($locationExist)) {
                        $response = Location::create($input);
                        $DataSynchronizeCounter++;
                    } else {
                        if ($locationExist->updated_at != Carbon::parse($location->updated_at)) {
                            $locationExist->update($input);
                            $DataSynchronizeCounter++;
                        }
                    }
                }
                return redirect()->route('synchronize-data')->with('success', $DataSynchronizeCounter . ' Location synchronized Successfully');
            } else {
                $locations = json_decode($locations);
                return back()->with('error', $locations->reason);
            }
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }

    public function synchronizeAssetsData()
    {
        $DataSynchronizeCounter = 0;
        // $resource = '/general-settings';
        $resource = '/get-assets';
        $apiEndpoint = env('API_BASE_URL') . env('API_VERSION') . $resource;

        try {

            //fetch data from API
            $generalSettings = Http::withHeaders(HttpHeader::pudoLocalHeader())
                ->get($apiEndpoint, ['request_type' => 'all_assets']);

            if ($generalSettings->successful()) {
                $generalSettings = json_decode($generalSettings);
                if ($generalSettings->code != 200) {
                    return $generalSettings->reason;
                }

                //fetch images from API data
                $generalSettingsData = json_decode(Encryption::apiDecryption($generalSettings->data));

                if (isset($generalSettingsData->logos) && count($generalSettingsData->logos) > 0) {
                    $logoArrFromApi = [];
                    $input['setting_location_id'] = $this->LocalLocationData->location_id;
                    $input['setting_name'] = 'logos';

                    foreach ($generalSettingsData->logos as $url) {
                        $finalImage = file_get_contents($url);
                        $imgName = substr($url, strrpos($url, '/') + 1);
                        Storage::put('public/logos/' . $imgName, $finalImage);
                        array_push($logoArrFromApi, $imgName);
                        $DataSynchronizeCounter++;
                    }

                    $input['setting_value'] = json_encode($logoArrFromApi);

                    //fetch data from DB
                    $existingGeneralSettingsForLogos = GeneralSetting::where('setting_name', 'logos')->first();

                    if (!isset($existingGeneralSettingsForLogos)) {
                        $response = GeneralSetting::create($input);
                    } else {
                        $logoArrFromDb = json_decode($existingGeneralSettingsForLogos->setting_value);
                        $existingImgToBeDeleted = array_diff($logoArrFromDb, $logoArrFromApi);

                        //delete old images
                        foreach ($existingImgToBeDeleted as $oldImg) {
                            Storage::delete('public/logos/' . $oldImg);
                        }
                        $existingGeneralSettingsForLogos->update(['setting_value' => $logoArrFromApi]);
                    }
                }

                if (isset($generalSettingsData->sliders) && count($generalSettingsData->sliders) > 0) {
                    $sliderArrFromApi = [];
                    $input['setting_location_id'] = $this->LocalLocationData->location_id;
                    $input['setting_name'] = 'sliders';

                    foreach ($generalSettingsData->sliders as $url) {
                        $finalImage = file_get_contents($url);
                        $imgName = substr($url, strrpos($url, '/') + 1);
                        Storage::put('public/sliders/' . $imgName, $finalImage);
                        array_push($sliderArrFromApi, $imgName);
                        $DataSynchronizeCounter++;
                    }

                    $input['setting_value'] = json_encode($sliderArrFromApi);

                    //fetch data from DB
                    $existingGeneralSettingsForSlider = GeneralSetting::where('setting_name', 'sliders')->first();

                    if (!isset($existingGeneralSettingsForSlider)) {
                        $response = GeneralSetting::create($input);
                    } else {
                        $sliderArrFromDb = json_decode($existingGeneralSettingsForSlider->setting_value);
                        $existingImgToBeDeleted = array_diff($sliderArrFromDb, $sliderArrFromApi);

                        //delete old images
                        foreach ($existingImgToBeDeleted as $oldImg) {
                            Storage::delete('public/sliders/' . $oldImg);
                        }
                        $existingGeneralSettingsForSlider->update(['setting_value' => $sliderArrFromApi]);
                    }
                }
                return redirect()->route('synchronize-data')->with('success', $DataSynchronizeCounter . ' Assets synchronized Successfully');
            } else {
                $generalSettings = json_decode($generalSettings);
                return back()->with('error', $generalSettings->reason);
            }
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }

    public function synchronizeUsersData()
    {
        $DataSynchronizeCounter = 0;
        $cloud_users = [];
        $local_users = [];

        $resource = '/userInfo';
        $apiEndpoint = env('API_BASE_URL') . env('API_VERSION') . $resource;

        try {
            $users = Http::withHeaders(HttpHeader::pudoLocalHeader())
                ->get($apiEndpoint);

            if ($users->successful()) {
                $users = json_decode($users);
                if ($users->code != 200) {
                    return $users->reason;
                }
                $usersData = json_decode(Encryption::apiDecryption($users->data));

                foreach ($usersData as $user) {
                    $input['user_id'] = $user->user_id;
                    $input['username'] = $user->user_name;
                    $input['name'] = $user->user_full_name;
                    $input['contact_no'] = $user->user_mobile_no;
                    $input['email'] = $user->email;
                    $input['address'] = $user->user_address;
                    $input['password'] = $user->password;
                    $input['otp'] = $user->user_otp;
                    $input['role_id'] = $user->role_id;
                    $input['company_id'] = $user->company_id;
                    $input['location_id'] = 1;
                    $input['is_active'] = $user->pivot->is_active;

                    $userExist = User::where('user_id', $user->user_id)->first();


                    if (!isset($userExist)) {
                        $response = User::create($input);
                        $DataSynchronizeCounter++;
                    } else {
                        if ($userExist->updated_at != Carbon::parse($user->updated_at)) {
                            $userExist->update($input);
                            $DataSynchronizeCounter++;
                        }
                    }

                    array_push($cloud_users, $user->user_id);
                }

                $local_users = User::where('role_id', 4)->pluck('user_id')->toArray();

                $RemainingLocalExistingUserInactiveArr = array_diff($local_users, $cloud_users);
                $local_users = array_values($RemainingLocalExistingUserInactiveArr);

                $response = User::whereIn('user_id', $local_users)
                    ->update(['is_active' => 0]);

                return redirect()->route('synchronize-data')->with('success', $DataSynchronizeCounter . ' Users synchronized Successfully');
            } else {
                $users = json_decode($users);
                return back()->with('error', $users->reason);
            }
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }

    public function syncBoxLocal2Cloud()
    {
        $resource = '/add/box/data';
        $apiEndpoint = env('API_BASE_URL') . env('API_VERSION') . $resource;

        $boxes = Box::all()->makeHidden(['id', 'is_soft_deleted', 'soft_deleted_at']);
        $boxes = Encryption::apiEncryption($boxes);

        try {
            $data = Http::withHeaders(HttpHeader::pudoLocalHeader())
                ->post($apiEndpoint, [
                    'data' => $boxes
                ]);
            return 'success';
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }

    public function syncBookingLocal2Cloud()
    {
        $resource = '/add/booking/data';
        $apiEndpoint = env('API_BASE_URL') . env('API_VERSION') . $resource;

        $bookings = Booking::where('booking_is_synced', 0)->get();
        $bookings = Encryption::apiEncryption($bookings);

        try {
            return $returnedData = Http::withHeaders(HttpHeader::pudoLocalHeader())
                ->post($apiEndpoint, [
                    'data' => $bookings
                ]);
            $returnedData = json_decode($returnedData);

            if (isset($returnedData)) {
                $response = Booking::whereIn('id', $returnedData->data)
                    ->update(['booking_is_synced' => 1]);
            }
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }

    public function syncMessageLocal2Cloud()
    {
        $resource = '/add/message/data';
        $apiEndpoint = env('API_BASE_URL') . env('API_VERSION') . $resource;

        $messages = Message::where('sms_is_sent', 1)
            ->where('sms_is_synced', 0)
            ->get();
        $messages = Encryption::apiEncryption($messages);

        try {
            $returnedData = Http::withHeaders(HttpHeader::pudoLocalHeader())
                ->post($apiEndpoint, [
                    'data' => $messages
                ]);
            $returnedData = json_decode($returnedData);

            if (isset($returnedData)) {
                $response = Message::whereIn('id', $returnedData->data)
                    ->update(['sms_is_synced' => 1]);
            }
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }

    public function syncEventLogLocal2Cloud()
    {
        $resource = '/add/event-log';
        $apiEndpoint = env('API_BASE_URL') . env('API_VERSION') . $resource;

        $eventLogs = EventLogModel::where('log_is_synced', 0)->get();
        $eventLogs = Encryption::apiEncryption($eventLogs);

        try {
            $returnedData = Http::withHeaders(HttpHeader::pudoLocalHeader())
                ->post($apiEndpoint, [
                    'data' => $eventLogs
                ]);
            $returnedData = json_decode($returnedData);

            if (isset($returnedData)) {
                $response = EventLogModel::whereIn('id', $returnedData->data)
                    ->update(['log_is_synced' => 1]);
            }
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }

    public function syncReturnBookingCloud2Local()
    {
        $resource = '/get-return-booking-data';
        $apiEndpoint = env('API_BASE_URL') . env('API_VERSION') . $resource;

        try {
            $bookings = Http::withHeaders(HttpHeader::pudoLocalHeader())
                ->get($apiEndpoint, ['locker_id' => $this->LocalLocationData->location_id]);


            if ($bookings->successful()) {
                $bookings = json_decode($bookings);
                if ($bookings->code != 200) {
                    return $bookings->reason;
                }
                $bookingsData = json_decode(Encryption::apiDecryption($bookings->data));

                foreach ($bookingsData as $booking) {
                    $input['booking_receiver_mobile_no'] = $booking->customer_no;
                    $input['customer_no_set_at'] = $booking->customer_no_set_at;
                    $input['booking_assigned_person_to_return'] = $booking->assigned_person_to_return;
                    $input['is_max_pickup_time_passed'] = $booking->is_max_pickup_time_passed;

                    $bookingExist = Booking::where('booking_id', $booking->booking_id)->first();

                    if (isset($bookingExist)) {
                        if ($bookingExist->updated_at != Carbon::parse($booking->updated_at)) {
                            $bookingExist->update($input);
                        }
                    }
                }
                return 'success';
            }
            return 'faild';
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }
    public function syncBoxesCloud2Local()
    {
        $resource = '/get-boxes-data';
        $apiEndpoint = env('API_BASE_URL') . env('API_VERSION') . $resource;

        try {
            $boxes = Http::withHeaders(HttpHeader::pudoLocalHeader())
                ->get($apiEndpoint, ['locker_id' => $this->LocalLocationData->location_id]);


            if ($boxes->successful()) {
                $boxes = json_decode($boxes);
                if ($boxes->code != 200) {
                    return $boxes->reason;
                }
                $boxesData = json_decode(Encryption::apiDecryption($boxes->data));

                foreach ($boxesData as $box) {
                    $input['emergency_box_open'] = $box->emergency_box_open;

                    $boxExist = Box::where('box_key', $box->box_key)->first();

                    if (isset($boxExist)) {
                        if ($boxExist->updated_at != Carbon::parse($box->updated_at)) {
                            $boxExist->update($input);
                        }
                    }
                }
                return 'success';
            }
            return 'faild';
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }

    public function syncUserCloud2Local()
    {
        $cloud_users = [];
        $local_users = [];

        $resource = '/userInfo';
        $apiEndpoint = env('API_BASE_URL') . env('API_VERSION') . $resource;

        try {
            $users = Http::withHeaders(HttpHeader::pudoLocalHeader())->get($apiEndpoint);

            if ($users->successful()) {
                $users = json_decode($users);
                if ($users->code != 200) {
                    return $users->reason;
                }
                $usersData = json_decode(Encryption::apiDecryption($users->data));

                foreach ($usersData as $user) {
                    $input['user_id'] = $user->user_id;
                    $input['username'] = $user->user_name;
                    $input['name'] = $user->user_full_name;
                    $input['contact_no'] = $user->user_mobile_no;
                    $input['email'] = $user->email;
                    $input['address'] = $user->user_address;
                    $input['password'] = $user->password;
                    $input['otp'] = $user->user_otp;
                    $input['role_id'] = $user->role_id;
                    $input['company_id'] = $user->company_id;
                    $input['location_id'] = 1;
                    $input['is_active'] = $user->pivot->is_active;

                    $userExist = User::where('user_id', $user->user_id)->first();

                    if (!isset($userExist)) {
                        $response = User::create($input);
                    } else {
                        // if ($userExist->updated_at != Carbon::parse($user->updated_at) || $userExist->is_active != $user->pivot->is_active) {
                        if ($userExist->updated_at != Carbon::parse($user->updated_at)) {
                            $userExist->update($input);
                        }
                    }

                    array_push($cloud_users, $user->user_id);
                }

                $local_users = User::where('role_id', 4)->pluck('user_id')->toArray();

                $RemainingLocalExistingUserInactiveArr = array_diff($local_users, $cloud_users);
                $local_users = array_values($RemainingLocalExistingUserInactiveArr);

                $response = User::whereIn('user_id', $local_users)
                    ->update(['is_active' => 0]);
            }
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }

        return 'success';
    }

    public function syncCompanyCloud2Local()
    {
        $resource = '/get-company';
        $apiEndpoint = env('API_BASE_URL') . env('API_VERSION') . $resource;

        try {
            $companies = Http::withHeaders(HttpHeader::pudoLocalHeader())
                ->get($apiEndpoint);

            if ($companies->successful()) {
                $companies = json_decode($companies);
                if ($companies->code != 200) {
                    return $companies->reason;
                }
                $companyData = json_decode(Encryption::apiDecryption($companies->data));

                foreach ($companyData as $company) {
                    $input['company_id'] = $company->company_id;
                    $input['company_name'] = $company->company_name;
                    $input['company_address'] = $company->company_address;
                    $input['company_contact_person_name'] = $company->company_contact_person_name;
                    $input['company_contact_person_number'] = $company->company_contact_person_number;
                    $input['company_email'] = $company->company_email;

                    $companyExist = Company::where('company_id', $company->company_id)->first();

                    if (!isset($companyExist)) {
                        $response = Company::create($input);
                    } else {
                        if ($companyExist->updated_at != Carbon::parse($company->updated_at)) {
                            $companyExist->update($input);
                        }
                    }
                }
            }
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }

    public function syncAssetsCloud2Local()
    {
        // $resource = '/general-settings';
        $resource = '/get-assets';
        $apiEndpoint = env('API_BASE_URL') . env('API_VERSION') . $resource;

        try {

            //fetch data from API
            $generalSettings = Http::withHeaders(HttpHeader::pudoLocalHeader())
                ->get($apiEndpoint, ['request_type' => 'all_assets']);

            if ($generalSettings->successful()) {
                $generalSettings = json_decode($generalSettings);
                if ($generalSettings->code != 200) {
                    return $generalSettings->reason;
                }

                //fetch images from API data
                $generalSettingsData = json_decode(Encryption::apiDecryption($generalSettings->data));

                if (isset($generalSettingsData->logos) && count($generalSettingsData->logos) > 0) {
                    $logoArrFromApi = [];
                    $input['setting_location_id'] = $this->LocalLocationData->location_id;
                    $input['setting_name'] = 'logos';

                    foreach ($generalSettingsData->logos as $url) {
                        $finalImage = file_get_contents($url);
                        $imgName = substr($url, strrpos($url, '/') + 1);
                        Storage::put('public/logos/' . $imgName, $finalImage);
                        array_push($logoArrFromApi, $imgName);
                    }

                    $input['setting_value'] = json_encode($logoArrFromApi);

                    //fetch data from DB
                    $existingGeneralSettingsForLogos = GeneralSetting::where('setting_name', 'logos')->first();

                    if (!isset($existingGeneralSettingsForLogos)) {
                        $response = GeneralSetting::create($input);
                    } else {
                        $logoArrFromDb = json_decode($existingGeneralSettingsForLogos->setting_value);
                        $existingImgToBeDeleted = array_diff($logoArrFromDb, $logoArrFromApi);

                        //delete old images
                        foreach ($existingImgToBeDeleted as $oldImg) {
                            Storage::delete('public/logos/' . $oldImg);
                        }
                        $existingGeneralSettingsForLogos->update(['setting_value' => $logoArrFromApi]);
                    }
                }

                if (isset($generalSettingsData->sliders) && count($generalSettingsData->sliders) > 0) {
                    $sliderArrFromApi = [];
                    $input['setting_location_id'] = $this->LocalLocationData->location_id;
                    $input['setting_name'] = 'sliders';

                    foreach ($generalSettingsData->sliders as $url) {
                        $finalImage = file_get_contents($url);
                        $imgName = substr($url, strrpos($url, '/') + 1);
                        Storage::put('public/sliders/' . $imgName, $finalImage);
                        array_push($sliderArrFromApi, $imgName);
                    }

                    $input['setting_value'] = json_encode($sliderArrFromApi);

                    //fetch data from DB
                    $existingGeneralSettingsForSlider = GeneralSetting::where('setting_name', 'sliders')->first();

                    if (!isset($existingGeneralSettingsForSlider)) {
                        $response = GeneralSetting::create($input);
                    } else {
                        $sliderArrFromDb = json_decode($existingGeneralSettingsForSlider->setting_value);
                        $existingImgToBeDeleted = array_diff($sliderArrFromDb, $sliderArrFromApi);

                        //delete old images
                        foreach ($existingImgToBeDeleted as $oldImg) {
                            Storage::delete('public/sliders/' . $oldImg);
                        }
                        $existingGeneralSettingsForSlider->update(['setting_value' => $sliderArrFromApi]);
                    }
                }
                return 'success';
            }
            return 'faild';
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }
}
