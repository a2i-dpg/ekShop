<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Contracts\View\View as View;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyBookingExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View{
        $companyID = [];
        foreach (session('allBookingData') as $value) {
            $companyID[]=$value->company_id;
        }
        $companyBookingData = Booking::whereIn('company_id',$companyID)
                                    ->get();
        return view('templates.export.CompanyBooking',[
            'companyBookingData'=> $companyBookingData
        ]);
    }
}
