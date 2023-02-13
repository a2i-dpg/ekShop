<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class BookingExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Booking::all();
    // }
    public function view(): View{
        return view('templates.export.booking',[
            'bookingData'=> session('allBookingData')
        ]);
    }
}
