<?php

namespace App\Http\Livewire\Analysis;

use App\Helpers\Helper;
use App\Models\Locker;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ReportAnalysis extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $lockers_asc_desc = "desc",
        $dataPoints_booking,
        $dataPoints_collection,
        $dataPoints_dropoff,
        $day_filter = 0,
        $searchText,
        $dataOfAllLockers,
        $lockerDataForChart,
        $paginate = 5,
        $dateRangeShow,
        $start_date,
        $end_date,
        $dateRange,
        $active;


    protected $listeners = ['setDateRange'];

    public function mount()
    {
        $this->dateRange = null;
    }

    public function render()
    {
        $today = Carbon::now()->format('Y-m-d');
        $dayFrom = Carbon::now()->subDays($this->day_filter)->format('Y-m-d');

        // dd($today);

        if (Helper::isMobile()) {
            $limitOfData = 5;
        } else {
            $limitOfData = 10;
        }

        $allLockers = Locker::search($this->searchText)
            ->where('location_is_active', 1)
            ->paginate($this->paginate);

        $this->dataOfAllLockers = [];
        $dataPoints = [];
        // dd($allLockers[0]);
        foreach ($allLockers as $key => $locker) {
            if($this->dateRange!=null){
                $bookingOrbj = $locker->bookings
                ->where('company_id', session('company_id'))
                ->whereBetween('booked_at', $this->dateRange);
            }else{
                if($this->day_filter == 1){
                    $bookingOrbj = $locker->bookings
                    ->where('company_id', session('company_id'))
                    ->where('booked_at', '>=', $dayFrom . ' 00:00:00')
                    ->where('booked_at', '<', $today . ' 00:00:00');
                }else{
                    $bookingOrbj = $locker->bookings
                    ->where('company_id', session('company_id'))
                    ->where('booked_at', '>=', $dayFrom . ' 00:00:00');
                }
                
            }
            // $bookingOrbj = $locker->bookings
            //     ->where('company_id', session('company_id'))
            //     ->when($this->dateRange!=null,function ($q) {
            //         $q->whereBetween('booked_at', $this->dateRange);
            //     })
            //     ->when(
            //         is_null($this->dateRange),
            //         function ($q) use ($dayFrom, $today) {
            //             $q->when(
            //                 $this->day_filter == 1,
            //                 function ($query) use ($dayFrom, $today) {
            //                     $query->where('booked_at', '>=', $dayFrom . ' 00:00:00')
            //                         ->where('booked_at', '<', $today . ' 00:00:00');
            //                 },
            //                 function ($query) use ($dayFrom) {
            //                     $query->where('booked_at', '>=', $dayFrom . ' 00:00:00');
            //                 }
            //             );
            //         }
            //     );

            // dd($bookingOrbj, $this->dateRange,$dayFrom,$today,$this->day_filter);



            // dd($bookingOrbj);
            if (isset($bookingOrbj)) {
                $total_booking = $bookingOrbj->count();
                $total_collected = $bookingOrbj
                    // ->whereNotNull('collected_at')
                    ->whereNotNull('collected_by')
                    ->where('booking_is_returned', 0)
                    ->count();

                $total_pending = $bookingOrbj
                    // ->whereNull('collected_at')
                    ->whereNull('collected_by')
                    ->count();

                $total_return = $bookingOrbj
                    // ->whereNull('collected_at')
                    ->where('booking_is_returned', 1)
                    ->count();

                // dd($total_booking, $total_collected,$total_pending, $total_return);

                $this->dataOfAllLockers[] = [
                    "locker_code" => $locker->locker_code,
                    "total_booking" => $total_booking,
                    "total_collect" => $total_collected,
                    "total_return" => $total_return,
                    "total_pending" => $total_pending,
                ];
                $dataPoints[] = array(
                    // array("label" => "Booking", "y" => $total_booking, "color" => "#aaf048"),
                    array("label" => "Collected", "y" => $total_collected, "color" => "#3cd0de"),
                    array("label" => "Return", "y" => $total_return, "color" => "#ff6b70"),
                    array("label" => "Pending", "y" => $total_pending, "color" => "#f2d44e")
                );
            }else{
                $this->dataOfAllLockers[] = [
                    "locker_code" => null,
                    "total_booking" => null,
                    "total_collect" => null,
                    "total_return" => null,
                    "total_pending" => null,
                ];

                $dataPoints[] = [];
            }
        }

        // This will rerender pie charts for every time component re-render with new data 
        $this->dispatchBrowserEvent('renderDataTable', $dataPoints);

        return view('livewire.analysis.report-analysis', compact(
            'limitOfData',
            'dataPoints',
            'allLockers'
        ))
            ->extends('master')
            ->section('content');
    }

    public function setDateRange($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->dateRangeShow = $start_date . ' - ' . $end_date;
        $this->dateRange = [date($this->start_date), date($this->end_date)];

        $this->active = -1;

        $this->day_filter = 0;
        
    }

    public function setDayFilter($dayFilter)
    {
        $this->day_filter = $dayFilter;
        $this->dateRange = null;
        $this->dateRangeShow = $dayFilter. " Days";
    }

    public function setChartData($i)
    {
        $this->lockerDataForChart =  $this->dataOfAllLockers[$i];

        $this->emit('renderDataTable');
    }
}
