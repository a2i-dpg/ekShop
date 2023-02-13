<?php

use App\Models\EventLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EventLogHelper
{

    public static function getValueIfExist($key,$array)
    {
        if(array_key_exists($key,$array)){
            $value = $array[$key];
        }else{
            $value = null;
        }
        return $value;
    }

    public static function formatData($rawData)
    {

        // $exsistingBooking,$category=null,$subCategory=null,$description=null

        $user = Auth::user();

        $exsistingBooking = EventLogHelper::getValueIfExist("booking",$rawData);
        $category = EventLogHelper::getValueIfExist("category",$rawData);
        $subCategory = EventLogHelper::getValueIfExist("sub_category",$rawData);
        $description = EventLogHelper::getValueIfExist("description",$rawData);
        // dd($exsistingBooking);
        // return $exsistingBooking;

        $booking_info = [
            "id"	=>	1,
            "booking_id"	=>	$exsistingBooking->booking_id,
            "created_at"	=>	$exsistingBooking->created_at,
            "updated_at"	=>	$exsistingBooking->updated_at,
            "booking_box_key"	=>	$exsistingBooking->box_id,
            "soft_deleted_at"	=>	$exsistingBooking->soft_deleted_at,
            "customer_sms_key"	=>	$exsistingBooking->customer_sms_key,
            "booking_booked_at"	=>	$exsistingBooking->booked_at,
            "booking_booked_by"	=>	$exsistingBooking->booked_by_user_id,
            "booking_is_synced"	=>	1,
            "booking_parcel_no"	=>	$exsistingBooking->parcel_no,
            "customer_no_set_at"	=>	$exsistingBooking->customer_no_set_at,
            // "booking_barcode_url"	=>	$exsistingBooking->,
            "booking_company_otp"	=>	$exsistingBooking->booking_company_otp,
            "booking_is_returned"	=>	$exsistingBooking->booking_is_returned,
            "booking_location_id"	=>	$exsistingBooking->locker_id,
            "booking_collected_at"	=>	$exsistingBooking->collected_at,
            "booking_collected_by"	=>	$exsistingBooking->collected_by,
            "booking_receiver_otp"	=>	$exsistingBooking->booking_receiver_otp,
            "booking_parcel_company_id"	=>	$exsistingBooking->company_id,
            "is_max_pickup_time_passed"	=>	$exsistingBooking->is_max_pickup_time_passed,
            "booking_receiver_mobile_no"	=>	$exsistingBooking->customer_no,
        ];

        $log_details = [
            'user' => $user->user_id,
            'contact_no' => $user->user_mobile_no,
            'booking_info'=> $booking_info
        ];
        $log_details = json_encode($log_details);
        $data = [
            'log_location_id' => $exsistingBooking->locker_id,
            'log_box_key' => $exsistingBooking->box_id,
            'log_event_category' => $category,
            'log_event_subcategory' => $subCategory,
            'log_event_type' => "null",
            'log_event_description' => $description,
            'log_details' => $log_details,
            'log_is_synced' => 1,
            'created_by' => $user->user_id,
        ];

        return $data;
    }

    // Create Event Log
    public static function createLog($data)
    {
        $data = (object) $data;
        $input = [
            "log_location_id" => $data->log_location_id,
            "log_box_key" => $data->log_box_key,
            "log_event_category" => $data->log_event_category,
            "log_event_subcategory" => $data->log_event_subcategory,
            "log_event_type" => $data->log_event_type,
            "log_event_description" => $data->log_event_description,
            "log_details" => $data->log_details,
            "log_is_synced" => $data->log_is_synced,
            "created_by" => $data->created_by,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ];

        // return  (object)$input;

        
        $newEvent = EventLog::insert($input);
        return  (object)$input;

        

        if (!isset($newEvent)) {
            $error = [
                'code' => '408',
                'reason' => 'Event log Can not create.'
            ];
            return (object) $error;
        }

        $success = [
            'code' => '200',
            'reason' => 'New event log created successfully.'
        ];
        return (object) $success;

        // return (object) $input;
    }
}
