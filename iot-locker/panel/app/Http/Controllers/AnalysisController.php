<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Locker;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function bookingAnalysis()
    {
        $today = Carbon::now()->subDays(60)->format('Y-m-d');

        $lockers_booking_count = Locker::withCount(['bookings'=> function ($booking) use ($today) {
            $booking->where('booked_at', '>=', $today . ' 00:00:00')
                ->where('company_id', session('company_id'));
        }])
            ->latest("bookings_count")
            ->limit(10)
            ->get();

        $dataPoints_booking =  [];
        foreach ($lockers_booking_count as $key => $locker) {
            $lockerCode = explode("-",$locker->locker_code);
            $lockerCode = $lockerCode[1];
            $dataPoints_booking[]= [
                "x"=> $key+1, 
                "y"=> $locker->bookings_count,
                "indexLabel"=> $lockerCode
            ];
        }

        $dataPoints = array(
            array("x"=> "DGBDDEX-DHTEJ", "y"=> 41),
            array("x"=> 20, "y"=> 35, "indexLabel"=> "Lowest"),
            array("x"=> 30, "y"=> 50),
            array("x"=> 40, "y"=> 45),
            array("x"=> 50, "y"=> 52),
            array("x"=> 60, "y"=> 68),
            array("x"=> 70, "y"=> 38),
            array("x"=> 80, "y"=> 71, "indexLabel"=> "Highest"),
            array("x"=> 90, "y"=> 52),
            array("x"=> 100, "y"=> 60),
            array("x"=> 110, "y"=> 36),
            array("x"=> 120, "y"=> 49),
            array("x"=> 130, "y"=> 41)
        );
        
        $dropoff = [
            ['label' => '2010', 'y' => 36.12],
            ['label' => '2011', 'y' => 34.87],
            ['label' => '2012', 'y' => 40.3],
            ['label' => '2013', 'y' => 35.3],
            ['label' => '2014', 'y' => 39.5],
            ['label' => '2015', 'y' => 50.82],
            ['label' => '2016', 'y' => 74.7]
        ];
        $collection = [
            ['label' => '2010', 'y' => 64.61],
            ['label' => '2011', 'y' => 70.55],
            ['label' => '2012', 'y' => 72.5],
            ['label' => '2013', 'y' => 81.3],
            ['label' => '2014', 'y' => 63.6],
            ['label' => '2015', 'y' => 69.38],
            ['label' => '2016', 'y' => 98.7]
        ];

        

        return view('analysis.booking_analysis', compact(
            'dropoff',
            'collection',
            'dataPoints_booking',
            'dataPoints'
        ));
    }
}
