<?php

namespace App\Http\Livewire\Admin;

use App\Events\SmsCheck;
use App\Exports\CompanyBookingData;
use App\Jobs\SendPickupSms;
use App\Models\Booking;
use App\Models\GenerelSettings;
use App\Models\MessageLog;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Session;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Allbooking extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $customer_no, $booking_by_user_id, $deliveryManNumber, $deliveryManEmail, $deliveryManAddress, $bookingStatus, $parcel_no, $booked_at, $locker_location, $box_no, $collect_at, $current_id, $allDeliveryMan, $assign_delivery_man, $max_pickup_time, $booking_is_returned, $assigned_person_to_return, $collected_by, $book_search_text, $bookingOrderBy = 'id', $asc_desc = false, $page_no = 10, $returnUserInfo, $fromDate = "1800-01-01 19:18:44", $toDate = "2090-01-01 19:18:44";



    public function render()
    {
        $this->fromDate = Carbon::parse($this->fromDate);
        $this->toDate = Carbon::parse($this->toDate);
        $allBooking = Booking::search($this->book_search_text)
            ->where('company_id', '=', session('company_id'))
            ->whereBetween('created_at', [$this->fromDate, $this->toDate])
            ->orderBy($this->bookingOrderBy, $this->asc_desc ? 'asc' : 'desc')
            ->paginate($this->page_no);

        Session::put('allBookingDataForExport', $allBooking);
        $todayDate = Carbon::now();
        $this->max_pickup_time = GenerelSettings::where('setting_name', 'max_pick_time')->first();
        // All Delivery Man Lists
        $this->allDeliveryMan = User::where('company_id', session('company_id'))
            ->where('soft_deleted_at', null)
            ->where('role_id', 4)
            ->orderby('created_at', 'desc')
            ->get();

        foreach ($allBooking as $value) {
            if ($todayDate->diffInHours($value->booked_at) > $this->max_pickup_time->setting_value) {
                $value->update(array('is_max_pickup_time_passed' => 1));
            } else {
                $value->update(array('is_max_pickup_time_passed' => 0));
            }
        }
        return view('livewire.admin.allbooking', ['allBooking' => $allBooking])
            ->extends('master')
            ->section('content');
    }
    
    public function clearFilter()
    {
        $this->book_search_text = '';
        $this->fromDate = "1800-01-01 19:18:44";
        $this->toDate = "2090-01-01 19:18:44";
    }
    // Booking Data View
    public function bookingView($id)
    {
        // dd('ok');
        $bookingData = Booking::where('id', $id)->first();
        $this->current_id = $bookingData->id;
        $this->customer_no = $bookingData->customer_no;
        $this->booking_by_user_id = $bookingData->user->user_full_name;
        $this->deliveryManNumber = $bookingData->user->user_mobile_no;
        $this->deliveryManEmail = $bookingData->user->email;
        $this->deliveryManAddress = $bookingData->user->user_address;
        $this->bookingStatus = $bookingData->is_max_pickup_time_passed;
        $this->parcel_no = $bookingData->parcel_no;
        $this->booked_at = Carbon::parse($bookingData->booked_at)->format('m/d/Y');
        $this->locker_location = $bookingData->locker->location_address;
        $this->box_no = $bookingData->box->box_no;
        $this->collect_at = $bookingData->collected_at;
        $this->assigned_person_to_return = $bookingData->assigned_person_to_return;
        $this->collected_by = $bookingData->collected_by;


        $findReturnUser = Booking::where('id', $id)
            ->where('assigned_person_to_return', '!=', null)

            ->first();
        if (!empty($findReturnUser)) {
            $this->returnUserInfo = User::where('user_id', $findReturnUser->assigned_person_to_return)
                ->first();
        } else {
            $this->returnUserInfo = null;
        }
        // dd($this->returnUserInfo);
    }

    // Assigned User for parcel returned
    public function assignd_user($id)
    {
        $assigned = Booking::with('box', 'user', 'locker')->findOrFail($id);
        $assigned->update(array('assigned_person_to_return' => $this->assign_delivery_man, 'booked_at' => Carbon::now()));

        $returnUser = User::where('user_id', $assigned->assigned_person_to_return)->first();
        $contactNumber = $returnUser->user_mobile_no;

        $smsBody = 'Please collect the parcel. Location:' . '' . $assigned->locker->location_address . '. Box Number: ' . '' . $assigned->box->box_no;
        $details = [
            'body' => $smsBody,
            'mobile' => ''
        ];
        $sms = new MessageLog();
        $sms->receiver_number = '';
        $sms->sms_text = $smsBody;
        $sms->save();
        event(new SmsCheck($sms));
        // SendPickupSms::dispatchSync($details);
        session()->flash('assigned', 'Delivery Man Assigned');
    }

    public function bookingDataExport()
    {
        return Excel::download(new CompanyBookingData, 'booking.xlsx');
    }


}
