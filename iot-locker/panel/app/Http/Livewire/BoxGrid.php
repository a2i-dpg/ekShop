<?php

namespace App\Http\Livewire;

use App\Models\Box;
use Livewire\Component;
use Livewire\WithPagination;

class BoxGrid extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $box_key,$box_no,$box_location,$locker_id,$location_landmark,$box_size,$box_is_online,$box_is_enable,$box_is_maintenance,$box_is_booked;
    public function render()
    {
        $boxData = Box::with('locker')->paginate(10);
        return view('livewire.box-grid',['boxData'=>$boxData]);
    }
    public function showBox($id){
        $singleBoxData = Box::where('id',$id)->with('locker')->first();
        $this->box_key = $singleBoxData->box_key;
        $this->box_no = $singleBoxData->box_no;
        $this->box_location = $singleBoxData->locker->location_address;
        $this->locker_id = $singleBoxData->locker->locker_id;
        if(empty($singleBoxData->locker->location_landmark)){
            $this->location_landmark = 'N/A';
        }else{
            $this->location_landmark = $singleBoxData->locker->location_landmark;
        }
        $this->box_size = $singleBoxData->box_size;
        if($singleBoxData->box_is_online == 0){
            $this->box_is_online = 'Offline';
        }else{
            $this->box_is_online = 'Online';
        }
        if($singleBoxData->box_is_enable == 0){
            $this->box_is_enable = 'Disable';
        }else{
            $this->box_is_enable = 'Enable';
        }
        if($singleBoxData->box_is_in_maintenance == 0){
            $this->box_is_maintenance = 'Running';
        }else{
            $this->box_is_maintenance = 'Maintenance';
        }
        if($singleBoxData->box_is_booked == 0){
            $this->box_is_booked = 'Empty';
        }else{
            $this->box_is_booked = 'Booked';
        }
    }
}
