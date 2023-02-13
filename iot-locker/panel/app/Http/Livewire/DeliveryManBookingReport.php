<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DeliveryManBookingReport extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $deliveryBookingList;
    public function render()
    {
        $deliveryManReport = Booking::where('company_id',session('company_id'))
                                    ->select(DB::raw('count(*) as `total`'), DB::raw('booked_by_user_id'))
                                    ->with('company','user')
                                    ->groupBy('booked_by_user_id')
                                    ->get();

        // dd($deliveryManReport);
        return view('livewire.delivery-man-booking-report',['deliveryManReport'=>$deliveryManReport,'deliveryBookingList'=>$this->deliveryBookingList]);
    }


    public function findDeliveryMan($id){
        $this->deliveryBookingList = Booking::where('booked_by_user_id',$id)
                                            ->with('user')
                                            ->get();
    }
}
