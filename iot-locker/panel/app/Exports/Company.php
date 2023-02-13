<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class Company implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
        
    // }

    public function view(): View{
        return view('templates.export.company',[
            'companyData'=> session('companyData')
        ]);
    }
}
