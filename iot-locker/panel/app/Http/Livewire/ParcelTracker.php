<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use App\Models\EventLog;
use Carbon\Carbon;
use Livewire\Component;

class ParcelTracker extends Component
{
    public $parcel_no,$mobile_no,$trackedParcel = null,$queryFrom;

    public function mount()
    {
        $this->queryFrom = Carbon::now()->subDay(90); //from last 365 days 
    }
    public function render()
    {
        $bookings = null;
        $eventLogs = null;
        $selectedBooking = null;

        

        // Search By Parcel No
        if (strlen($this->parcel_no) >= 6) {
            $bookings = Booking::where('parcel_no', 'LIKE', "%{$this->parcel_no}%")
            ->where('created_at', '>' , $this->queryFrom)
            ->orderBy('id', 'DESC')
            ->get();

            // dd ($bookings);
            
            if(count($bookings) == 0){
                $selectedBooking = null;
                $this->trackedParcel = null;
            }
            else if(count($bookings) == 1){
                $this->trackedParcel = $bookings[0]->parcel_no;
                $this->parcel_no = $this->trackedParcel;
            }else{
                // $selectedBooking = null;
                // $this->trackedParcel = null;
            }
        }

        // Search By Phone Number
        if (strlen($this->mobile_no) >= 10) {
            $bookings = Booking::Where('customer_no',$this->mobile_no)
            ->where('created_at', '>' , $this->queryFrom)
            ->orderBy('id', 'DESC')
            ->get();

            if(count($bookings) == 0){
                $selectedBooking = null;
                $this->trackedParcel = null;
            }
            else if(count($bookings) == 1){
                $this->trackedParcel = $bookings[0]->parcel_no;
                $this->parcel_no = $this->trackedParcel;
            }else{
                // $selectedBooking = null;
                // $this->trackedParcel = null;
            }
        }

        // dd($selectedBooking,$this->trackedParcel);
        if ($this->trackedParcel != null) {
            $selectedBooking = Booking::where('parcel_no', $this->trackedParcel)
            ->first();
            $eventLogs = EventLog::where('created_at', '>' , $this->queryFrom)
            ->whereJsonContains("log_details->booking_info->booking_parcel_no", $this->trackedParcel)
            ->get();
            // dd($eventLogs);
        }

        
        return view('livewire.parcel-tracker', compact(
            'bookings',
            'eventLogs',
            'selectedBooking'
        ))->extends('master')->section('content');
    }

    public function trackParcel($parcelNo)
    {
        $this->trackedParcel = $parcelNo;
        $this->parcel_no = $parcelNo;
        // dd($parcelNo);
    }
}
