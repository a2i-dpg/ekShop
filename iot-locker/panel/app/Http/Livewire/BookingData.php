<?php

namespace App\Http\Livewire;

use App\Exports\BookingExport;
use App\Models\Booking;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class BookingData extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $company,$search_text,$orderBy='id',$page_no = 10,$asc_desc = false,$customer_no,$booking_by_user_id,$deliveryManNumber,$deliveryManEmail,$deliveryManAddress,$bookingStatus,$parcel_no,$booked_at,$locker_location,$box_no,$collect_at,$current_id,$allDeliveryMan,$assign_delivery_man,$max_pickup_time,$booking_is_returned,$assigned_person_to_return,$collected_by,$filter_company;
    
    public function render()
    {
        $allBookingData = Booking::searchBookingData($this->search_text)
                                ->with('company')
                                ->orderBy($this->orderBy,$this->asc_desc?'asc':'desc')
                                ->paginate($this->page_no);
        Session::put('allBookingData',$allBookingData);
        $this->company = Booking::groupBy('company_id')->select('company_id')->get();
        return view('livewire.booking-data',['allBookingData'=>$allBookingData])->extends('master')->section('content');
    }
    public function bookingView($id){
        // dd('ok');
        $bookingData = Booking::where('id',$id)->first();
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
    }
    public function bookExport(){
        return Excel::download(new BookingExport,'booking.xlsx');
    }
    public function bookExportPdf(){
        return Excel::download(new BookingExport,'booking.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
    public function bookExportCSV(){
        return Excel::download(new BookingExport,'booking.csv');
    }
}
