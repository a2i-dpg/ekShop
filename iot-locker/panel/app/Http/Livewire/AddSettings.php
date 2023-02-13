<?php

namespace App\Http\Livewire;

use App\Models\GenerelSettings;
use App\Models\Locker;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AddSettings extends Component
{
    use WithFileUploads;
    public $showDiv = false,$showDivimg = false,$setting_name,$setting_value_img=[],$setting_value,$allLocker,$locker_id,$setting_images=[];
    public function render()
    {
        $this->allLocker = Locker::where('soft_deleted_at',null)->get();
        return view('livewire.add-settings')
                ->extends('master')
                ->section('content');
    }

    public function getSettings($value){
        $this->setting_name = $value;
        if($this->setting_name==='logo' || $this->setting_name==='slider'){
            $this->showDivimg =! $this->showDivimg;
            $this->showDiv =false;
            
        }elseif($this->setting_name==='admin_secret' || $this->setting_name==='max_pick_time' || $this->setting_name==='appKey'){
            $this->showDiv =! $this->showDiv;
            $this->showDivimg =false;
        }
    }

    public function clearInput(){
        $this->setting_name = '';
        $this->setting_value = '';
        $this->setting_value_img = '';
    }
    public function settings_save(){
        $this->validate([
            'setting_name' => 'required',
            // 'setting_value_img' => 'required|image|mimes:jpeg,jpg,png,svg,ico|max:2048', // 2MB Max
        ],[
            'setting_name.required'=>'Setting name required',
            // 'setting_value_img.required'=>'Please select images',
        ]);
        $setting = new GenerelSettings();
        $setting->setting_name = $this->setting_name;
        $setting->locker_id = $this->locker_id;
        $setting->settings_id = 'setting'.''.Str::random(4); 

        if($this->setting_value_img){
            // dd($this->setting_value_img);
            foreach ($this->setting_value_img as $key=>$image) {
                $this->setting_images[$key] = $image->store('images','public');
            }
            $setting->setting_value = json_encode($this->setting_images);
        }else{
            $setting->setting_value = $this->setting_value;
        }
        $setting->save();
        $this->clearInput();
        session()->flash('success','Setting add successfully');
    }
}
