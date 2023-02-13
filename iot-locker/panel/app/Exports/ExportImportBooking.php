<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ExportImportBooking implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
        
    // }

    public function view(): View{
        return view('templates.export.ExportImportBooking',[
            'companyBookingDataFromSession'=>session("allBookingDataForExport")
        ]);
    }
}
