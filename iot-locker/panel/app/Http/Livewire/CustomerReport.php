<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerReport extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $customer_number,$page_no=10;
    protected $customerBookingList;
    public function render()
    {
        $customerData = Booking::searchBook($this->customer_number)
                                ->where('collected_by','=',null)
                                ->where('collected_at','!=',null)
                                ->select(DB::raw('count(*) as `total`'),DB::raw('customer_no'))
                                ->groupBy('bookings.customer_no')
                                ->paginate($this->page_no);
        return view('livewire.customer-report',['customerData'=>$customerData,'customerBookingList'=>$this->customerBookingList]);
    }

    public function findCustomer($number){
        $this->customerBookingList = Booking::where('customer_no',$number)
                                            ->with('company')
                                            ->select(DB::raw('count(*) as `total`'),DB::raw('company_id'))
                                            ->groupBy('company_id')
                                            ->paginate(10);
    }

}
