<?php

namespace App\Http\Livewire;

use App\Models\District;
use App\Models\Division;
use App\Models\Union;
use App\Models\Upazila;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CreateLocation extends Component
{
    public $showdivision=true,$showdistrict=false,$showUpazila = false,$showUnion=false,$division,$district,$upazila,$uni_name,$upazila_name,$dis_name,$div_name,$div_id,$dis_id,$upazilla_id;
    public function render()
    {
        $this->division = Division::all();
        $this->district = District::all();
        $this->upazila = Upazila::all();
        return view('livewire.create-location')->extends('master')->section('content');
    }
    public function division_add(){
        $this->validate([
            'div_name'=>'required'
        ],[
            'div_name.required'=>'Please type division name',
        ]);
        $division = Division::all();
        foreach ($division as $value) {
            $div_name = strtolower($value->name);
            $input_div = strtolower($this->div_name);
            if($div_name===$input_div){
                session()->flash('error','Division already exist');
                return;
            }
        }
        $div = new Division();
        $div->name = $this->div_name;
        $div->save();
        $this->div_name = "";
        session()->flash('message','Division add successfully');
        
    }
    public function district_add(){
        
        $this->validate([
            'div_id'=>'required|not_in:0',
            'dis_name'=>'required'
        ],[
            'div_id.required'=>'Please select division',
            'dis_name.required'=>'Please type district name',
        ]);
        $district = District::all();
        foreach ($district as $value) {
            $dis_name = strtolower($value->name);
            $input_dis = strtolower($this->dis_name);
            if($dis_name===$input_dis && $value->division_id === $this->div_id){
                session()->flash('error','District already exist');
                return;
            }
        }
        $dis = new District();
        $dis->division_id = $this->div_id;
        $dis->name = $this->dis_name;
        $dis->save();
        $this->div_id = "";
        $this->dis_name = "";
        session()->flash('message','District add successfully');
    }
    public function upazila_add(){
        $this->validate([
            'upazila_name'=>'required',
            'dis_id'=>'required|not_in:0'
        ],[
            'upazila_name.required'=>'Upazila name required',
            'dis_id.required'=>'Please select district'
        ]);
        $upazila = Upazila::all();
        foreach ($upazila as $value) {
            $upazila_name = strtolower($value->name);
            $input_upazila = strtolower($this->upazila_name);
            if($upazila_name===$input_upazila && $value->district_id === $this->dis_id){
                session()->flash('error','Upazila already exist');
                return;
            }
        }
        $upa_zila = new Upazila();
        $upa_zila->district_id = $this->dis_id;
        $upa_zila->name = $this->upazila_name;
        $upa_zila->save();
        $this->dis_id = "";
        $this->upazila_name = "";
        session()->flash('message','Upazila add successfully');
    }
    public function union_add(){
        $this->validate([
            'uni_name'=>'required',
            'upazilla_id'=>'required|not_in:0'
        ],[
            'uni_name.required'=>'Union name required',
            'upazilla_id.required'=>'Please select upazila'
        ]);
        $union = Union::all();
        foreach ($union as $value) {
            $union_name = strtolower($value->name);
            $input_union = strtolower($this->uni_name);
            if($union_name===$input_union && $value->upazilla_id === $this->upazilla_id){
                session()->flash('error','Union already exist');
                return;
            }
        }
        $union_new = new Union();
        $union_new->upazilla_id = $this->upazilla_id;
        $union_new->name = $this->uni_name;
        $union_new->save();
        $this->upazilla_id = "";
        $this->uni_name = "";
        session()->flash('message','Union add successfully');
    }
    public function showDivision(){
        $this->showdistrict=false;
        $this->showdivision = !$this->showdivision;
        $this->showUpazila = false;
        $this->showUnion = false;
    }
    public function showDistrict(){
        $this->showdistrict=!$this->showdistrict;
        $this->showdivision = false;
        $this->showUpazila = false;
        $this->showUnion = false;
    }
    public function showUpazila(){
        $this->showdistrict=false;
        $this->showdivision = false;
        $this->showUpazila = !$this->showUpazila;
        $this->showUnion = false;
    }
    public function showUnion(){
        $this->showdistrict=false;
        $this->showdivision = false;
        $this->showUnion = !$this->showUnion;
        $this->showUpazila = false;
    }
    
}
