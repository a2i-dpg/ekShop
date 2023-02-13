<?php

namespace App\Http\Livewire;

use App\Models\GenerelSettings as ModelsGenerelSettings;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class GenerelSettings extends Component
{
    public $logoSettings,$sliderSettings,$admin_secretSettings,$max_pickSettings,$appKey;
    public function render()
    {
        $this->logoSettings = ModelsGenerelSettings::where('setting_name','logo')->with('locker')->get();
        $this->sliderSettings = ModelsGenerelSettings::where('setting_name','slider')->with('locker')->get();
        $this->admin_secretSettings = ModelsGenerelSettings::where('setting_name','admin_secret')->with('locker')->get();
        $this->max_pickSettings = ModelsGenerelSettings::where('setting_name','max_pick_time')->with('locker')->get();
        $this->appKey = ModelsGenerelSettings::where('setting_name','appKey')->with('locker')->get();
        
        return view('livewire.generel-settings')
                ->extends('master')
                ->section('content');
    }

    public function settingDelete($id){
        $settings = ModelsGenerelSettings::findOrFail($id);
        $image = str_replace(['[','"','"',']','images'],'',$settings->setting_value);
        $images = explode(',',$image);
        // dd(gettype($images));
        if($settings->delete()){
            
            if($settings->setting_name === 'logo' || $settings->setting_name ==='slider'){
                
                foreach ($images as $value) {
                    File::delete([
                        public_path('storage/images/'. $value),
                    ]);
                }
            }
        }
        session()->flash('message','Setting delete success');
    }
}
