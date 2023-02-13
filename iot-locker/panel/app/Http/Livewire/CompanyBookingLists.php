<?php

namespace App\Http\Livewire;

use App\Exports\CompanyBookingExport;
use App\Models\Booking;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class CompanyBookingLists extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap',$companyDetails;
    public $search_text,$page_no = 10;
    public function render()
    {
        $bookingData = Booking::searchCompany($this->search_text)
                            ->select(DB::raw('count(*) as `data`'),DB::raw('YEAR(created_at) year, MONTH(created_at) month'), DB::raw('company_id'))
                            ->with('company')
                            ->groupBy('month','year','company_id')
                            ->paginate($this->page_no);

        Session::put('bookingData',$bookingData);
        return view('livewire.company-booking-lists',['bookingData'=>$bookingData,'companyDetails'=>$this->companyDetails]);
    }
    public function findCompanyDetails($company_id){
        $this->companyDetails = Company::where('company_id',$company_id)->first();
    }
    public function companyBookingExport(){
        return Excel::download(new CompanyBookingExport,'Company-data-booking.xlsx');
    }
}
