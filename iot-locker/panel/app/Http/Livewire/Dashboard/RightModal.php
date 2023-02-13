<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Booking;
use App\Models\Box;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RightModal extends Component
{
    protected $listeners = ['showRightModal'];
    public $boxId = 1,$userRole=null,$inputPermission;

    // public $customerNumber;
    // public function customerNumberSave()
    // {
        
    // }

    public function mount()
    {
        $this->userRole = Auth::user()->role->role_slug;
        $this->inputPermission = 0;
        if ($this->userRole === 'company-admin' || $this->userRole === 'super-admin' || $this->userRole === 'company-agent'){
            $this->inputPermission = 1;
        }
    }

    public function render()
    {
        
        $box = Box::find($this->boxId);
        if(isset($box)){
            // dd($box);
            $currentBooking = Booking::where('booking_id',$box->booking_id)->first();
            return view('livewire.dashboard.right-modal',['box'=>$box, 'currentBooking' => $currentBooking]);
        }
        return view('livewire.dashboard.right-modal');
    }

    public function showRightModal($box_id)
    {
        $this->boxId = $box_id;
        $this->emit('showModal');
    }

}
