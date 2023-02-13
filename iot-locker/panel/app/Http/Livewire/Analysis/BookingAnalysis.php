<?php

namespace App\Http\Livewire\Analysis;

use App\Helpers\Helper;
use App\Models\Locker;
use Carbon\Carbon;
use Livewire\Component;

class BookingAnalysis extends Component
{
    public $lockers_asc_desc = "desc", 
    $dataPoints_booking,
    $dataPoints_collection,
    $dataPoints_dropoff,
    $day_filter = 7;

    public function mount()
    {
    }
    public function render()
    {
        $today = Carbon::now()->subDays(60)->format('Y-m-d');
        $dayFrom = Carbon::now()->subDays($this->day_filter)->format('Y-m-d');
        
        if(Helper::isMobile()){
            $limitOfData = 5;
        }else{
            $limitOfData = 10;
        }

        $lockers_booking_obj = Locker::withCount(['bookings' => function ($booking) use ($dayFrom) {
            $booking->where('booked_at', '>=', $dayFrom . ' 00:00:00')
                ->where('company_id', session('company_id'));
        }])->orderBy("bookings_count", $this->lockers_asc_desc)
            ->limit($limitOfData);

        $lockers_booking = $lockers_booking_obj->get();

        $this->dataPoints_booking =  [];
        $this->dataPoints_collection =  [];
        $this->dataPoints_dropoff =  [];
        foreach ($lockers_booking  as $key => $locker) {
            // dd($locker->bookings->where('booked_at', '>=', $dayFrom . ' 00:00:00')
            //     ->whereNotNull('collected_by')
            //     ->count());

            $collection_amount = $locker->bookings->where('booked_at', '>=', $dayFrom . ' 00:00:00')
            ->whereNotNull('collected_by')
            ->count();

            $lockerCode = explode("-", $locker->locker_code);
            $lockerCode = $lockerCode[1];
            $this->dataPoints_booking[] = [
                "x" => $key + 1,
                "y" => $locker->bookings_count,
                "indexLabel" => $lockerCode
            ];

            $this->dataPoints_dropoff[] = [
                "label" => $lockerCode,
                "y" => $locker->bookings_count,
            ];
            $this->dataPoints_collection[] =[
                "label" => $lockerCode,
                "y" => $collection_amount,
            ];
        }
        $this->dispatchBrowserEvent('render_top_lockers_chart', $this->dataPoints_booking);

        $this->dispatchBrowserEvent('render_booking_by_date_chart', [$this->dataPoints_dropoff,$this->dataPoints_collection]);

        // $collections = $lockers_booking_obj->whereHas("bookings",function($q){
        //     $q->whereNotNull('collected_by');
        // })->get();
        // dd($collections); 

        // Booking Analysis by Day
        $dataPoints1 = array(
            array("label" => "2010", "y" => 36.12),
            array("label" => "2011", "y" => 34.87),
            array("label" => "2012", "y" => 40.30),
            array("label" => "2013", "y" => 35.30),
            array("label" => "2014", "y" => 39.50),
            array("label" => "2015", "y" => 50.82),
            array("label" => "2016", "y" => 74.70)
        );
        $dataPoints2 = array(
            array("label" => "2010", "y" => 64.61),
            array("label" => "2011", "y" => 70.55),
            array("label" => "2012", "y" => 72.50),
            array("label" => "2013", "y" => 81.30),
            array("label" => "2014", "y" => 63.60),
            array("label" => "2015", "y" => 69.38),
            array("label" => "2016", "y" => 98.70)
        );

        return view('livewire.analysis.booking-analysis', compact(
            'dataPoints1',
            'dataPoints2',
            'limitOfData'
        ))
            ->extends('master')
            ->section('content');
    }

    public function setDayFilter($dayFilter)
    {
        $this->day_filter = $dayFilter;
    }
}
