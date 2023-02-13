<?php

namespace App\Http\Livewire\Analysis;

use App\Models\Locker;
use Carbon\Carbon;
use Livewire\Component;

class LockerAnalysis extends Component
{
    public $lockers_asc_desc = "desc",
        $dataPoints_booking,
        $dataPoints_collection,
        $dataPoints_dropoff,
        $dataPoints_locker_bookings,
        $day_filter = 7;

    public function mount()
    {
    }
    public function render()
    {
        $today = Carbon::now()->subDays(60)->format('Y-m-d');
        $dayFrom = Carbon::now()->subDays($this->day_filter)->format('Y-m-d');

        $lockers_booking_obj = Locker::withCount(['bookings' => function ($booking) use ($dayFrom) {
            $booking->where('booked_at', '>=', $dayFrom . ' 00:00:00')
                ->where('company_id', session('company_id'));
        }])->orderBy("bookings_count", $this->lockers_asc_desc)
            ->limit(10);

        $lockers_booking = $lockers_booking_obj->get();

        $this->dataPoints_locker_bookings =  [];
        $this->dataPoints_booking =  [];
        $this->dataPoints_collection =  [];
        $this->dataPoints_dropoff =  [];
        foreach ($lockers_booking  as $key => $locker) {
            // dd($locker->bookings->where('booked_at', '>=', $dayFrom . ' 00:00:00')
            //     ->whereNotNull('collected_by')
            //     ->count());

            $dropOff_amount = $locker->bookings_count;
            $collection_amount = $locker->bookings->where('booked_at', '>=', $dayFrom . ' 00:00:00')
                ->whereNotNull('collected_by')
                ->count();

            $notCollected_amount = $locker->bookings->where('booked_at', '>=', $dayFrom . ' 00:00:00')
                ->whereNull('collected_by')
                ->count();

            $returnByRider_amount = $locker->bookings->where('booked_at', '>=', $dayFrom . ' 00:00:00')
                ->where('is_max_pickup_time_passed', 1)
                ->where('booking_is_returned', 1)
                ->whereNotNull('collected_by')
                ->count();

            $returnByAgent_amount = $locker->bookings->where('booked_at', '>=', $dayFrom . ' 00:00:00')
                ->where('is_max_pickup_time_passed', 0)
                ->where('booking_is_returned', 1)
                ->whereNotNull('collected_by')
                ->count();

            
            $collected = $this->getPercentage($collection_amount,$dropOff_amount);
            $notCollected = $this->getPercentage($notCollected_amount,$dropOff_amount);
            $returnByRider = $this->getPercentage($returnByRider_amount,$dropOff_amount);
            $returnByAgent = $this->getPercentage($returnByAgent_amount,$dropOff_amount);


            $lockerCode = explode("-", $locker->locker_code);
            $lockerCode = $lockerCode[1];

            $dataPoints = array(
                array("label" => "Collected", "y" => $collected),
                array("label" => "Not collected", "y" => $notCollected),
                array("label" => "Return by rider", "y" => $returnByRider),
                array("label" => "Return by agent", "y" => $returnByAgent)
            );
            // $this->dataPoints_booking[] = [
            //     "x" => $key + 1,
            //     "y" => $locker->bookings_count,
            //     "indexLabel" => $lockerCode
            // ];

            // $this->dataPoints_dropoff[] = [
            //     "label" => $lockerCode,
            //     "y" => $locker->bookings_count,
            // ];
            // $this->dataPoints_collection[] = [
            //     "label" => $lockerCode,
            //     "y" => $collection_amount,
            // ];
        }

        $this->dispatchBrowserEvent('render_top_lockers_chart', $this->dataPoints_booking);

        $this->dispatchBrowserEvent('render_booking_by_date_chart', [$this->dataPoints_dropoff, $this->dataPoints_collection]);

        $dataPoints = array(
            array("label" => "Chrome", "y" => 64.02),
            array("label" => "Firefox", "y" => 12.55),
            array("label" => "IE", "y" => 8.47),
            array("label" => "Safari", "y" => 6.08),
            array("label" => "Edge", "y" => 4.29),
            array("label" => "Others", "y" => 4.59)
        );

        return view('livewire.analysis.locker-analysis', compact(
            'dataPoints'
        ))
            ->extends('master')
            ->section('content');
    }

    public function setDayFilter($dayFilter)
    {
        $this->day_filter = $dayFilter;
    }

    public function getPercentage($percentage,$total)
    {
        return $new_amount = ($percentage / 100) * $total;
    }
}
