<?php

namespace App\Http\Livewire\Admin\Agent;

use App\Events\SmsCheck;
use App\Exports\CompanyBookingData;
use App\Exports\ExportImportBooking as ExportsExportImportBooking;
use App\Models\Booking;
use App\Models\Company;
use App\Models\GenerelSettings;
use App\Models\Locker;
use App\Models\MessageLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ExportImportBooking extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $customer_no, $booking_by_user_id, $deliveryManNumber,
        $deliveryManEmail, $deliveryManAddress, $bookingStatus, $parcel_no,
        $booked_at, $locker_location, $box_no, $collect_at, $current_id,
        $allDeliveryMan, $assign_delivery_man, $max_pickup_time, $booking_is_returned,
        $assigned_person_to_return, $collected_by, $book_search_text,
        $bookingOrderBy = 'id', $asc_desc = false, $page_no = 10, $returnUserInfo,
        $fromDate = "1800-01-01 19:18:44", $toDate = "2090-01-01 19:18:44", $selectedDate, $userRole, $userId;

    public $bookingFilter, 
    $user, 
    $company_id,
    $selectedLocation = null,
    $selectedLocationCode;

    public function mount()
    {
        $this->dateForReport = Carbon::now();
        $this->bookingFilter = "new_booking";

        // $this->selectedDate = Carbon::now();

        $this->userId = Auth::user()->id;
        $this->user = User::where('id', $this->userId)->first();
        $company = Company::where('company_id', $this->user->company_id)->first();
        $this->company_id = $company->id;

        // User Role For Locker list
        $this->userRole = Auth::user()->role->role_slug;
    }

    public function render()
    {
        if($this->selectedLocation){
            $selectedLocker = Locker::where('locker_id',$this->selectedLocation)->first();
            $this->selectedLocationCode = $selectedLocker->locker_code;
        }
        Session::forget(['errorCheckMessage', 'dataChangeCounter']);

        $this->fromDate = Carbon::parse($this->fromDate);
        $this->toDate = Carbon::parse($this->toDate);

        if ($this->userRole === 'company-admin' || $this->userRole === 'super-admin') {
            $lockers = Locker::where('company_id', $this->company_id)
                ->where('location_is_active',1)
                ->get();
            // dd($lockers->pluck('locker_id'));
        } else {
            $loggedInUser =  User::where('id',  $this->userId)->with(['lockers' => function ($query) {
                $query->where('is_active', 1);
            }])->first();

            $lockers = $loggedInUser->lockers; //here locakers is the locations (DB)
            // dd($lockers->pluck('locker_id'));
        }


        $locker_ids = $lockers->pluck('locker_id');
        if ($this->bookingFilter == "new_booking") {
            $allBooking = Booking::search($this->book_search_text, $this->selectedDate)
                ->where('company_id', '=', session('company_id'))
                ->whereNull("customer_no")
                ->whereNull("customer_sms_key")
                ->where("is_max_pickup_time_passed",0)
                ->where("booking_is_returned",0)
                ->when($this->selectedLocation, function ($q) {
                    $q->where('locker_id', $this->selectedLocation);
                })
                ->when(is_null($this->selectedLocation), function ($q) use ($locker_ids)  {
                    $q->whereIn('locker_id', $locker_ids);
                })
                // ->whereBetween('created_at', [$this->fromDate, $this->toDate])
                // ->whereIn('locker_id', $locker_ids)
                ->orderBy($this->bookingOrderBy, $this->asc_desc ? 'asc' : 'desc')
                ->paginate($this->page_no);
        } else if ($this->bookingFilter == "returned") {
            $allBooking = Booking::search($this->book_search_text, $this->selectedDate)
                ->where('company_id', '=', session('company_id'))
                ->where('is_max_pickup_time_passed', 1)
                // ->Where('booking_is_returned', 1)
                ->when($this->selectedLocation, function ($q) {
                    $q->where('locker_id', $this->selectedLocation);
                })
                ->when(is_null($this->selectedLocation), function ($q) use ($locker_ids)  {
                    $q->whereIn('locker_id', $locker_ids);
                })
                // ->whereBetween('created_at', [$this->fromDate, $this->toDate])
                // ->whereIn('locker_id', $locker_ids)
                ->orderBy($this->bookingOrderBy, $this->asc_desc ? 'asc' : 'desc')
                ->paginate($this->page_no);
        } else {
            $allBooking = Booking::search($this->book_search_text, $this->selectedDate)
                ->where('company_id', '=', session('company_id'))
                ->when($this->selectedLocation, function ($q) {
                    $q->where('locker_id', $this->selectedLocation);
                })
                ->when(is_null($this->selectedLocation), function ($q) use ($locker_ids)  {
                    $q->whereIn('locker_id', $locker_ids);
                })
                // ->whereBetween('created_at', [$this->fromDate, $this->toDate])
                // ->whereIn('locker_id', $locker_ids)
                ->orderBy($this->bookingOrderBy, $this->asc_desc ? 'asc' : 'desc')
                ->paginate($this->page_no);
        }

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

        return view('livewire.admin.agent.export-import-booking', ['allBooking' => $allBooking, "lockers" => $lockers])
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
        return Excel::download(new ExportsExportImportBooking, 'booking-list-' . $this->dateForReport . '.csv');
    }
}
