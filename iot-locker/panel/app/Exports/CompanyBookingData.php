<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyBookingData implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View{
        return view('templates.export.CompanyBookingFromSession',[
            'companyBookingDataFromSession'=>session("allBookingDataForExport")
        ]);
    }
}
