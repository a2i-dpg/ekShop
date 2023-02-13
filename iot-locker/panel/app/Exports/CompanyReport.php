<?php

namespace App\Exports;

use Illuminate\View\View;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyReport implements FromView
{

    public function view(): View
    {
        return view('templates.export.company_booking_report_export', [
            'bookings' => session('bookings')
        ]);
    }
}
