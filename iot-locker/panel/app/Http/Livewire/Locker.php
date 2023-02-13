<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Country;
use App\Models\DisplayResolution;
use App\Models\District;
use App\Models\Division;
use App\Models\Locker as ModelsLocker;
use App\Models\Union;
use App\Models\Upazila;
use Livewire\Component;

class Locker extends Component
{
    public $division, $district, $upazila, $union, $locker_landmark,$address, 
    $locker_id, 
    $locker_code, 
    $division_id, 
    $district_id, 
    $upazilla_id, 
    $union_id, 
    $display_resolutions,
    $display_resolution_id,
    $div_name,
    $country_name,
    $company_name,
    $district_name, 
    $upazila_name, 
    $union_name,
    $companies,
    $selectedCompany_code,
    $selectedDivision_code,
    $selectedCountryID,
    $selectedCompanyID,
    $selectedCountry_code,
    $extra_code,
    $duplicate_locker;

    protected $listeners = [
        'findDistrict',
    ];
    public function render()
    {
        $this->countries = Country::whereIn('country_code',["BD","IN"])->get();
        $this->division = Division::all();
        $this->companies = Company::all();

        $this->display_resolutions = DisplayResolution::all();

        $this->locker_id = null;

        if(isset($this->selectedCountry_code)){
            $this->locker_id = "DG".$this->selectedCountry_code;
        }
        if(isset($this->selectedCompany_code)){
            $this->locker_id = $this->locker_id."".$this->selectedCompany_code;
        }
        if(isset($this->selectedDivision_code)){
            $this->locker_id = $this->locker_id."-".$this->selectedDivision_code;
        }
        if(isset($this->extra_code)){
            // $this->extra_code = strtoupper($this->extra_code);
            $this->locker_id = $this->locker_id."".strtoupper($this->extra_code);
        }
        
        $this->setLockerCode();
        $this->checkDuplicate();

        return view('livewire.locker')
            ->extends('master')
            ->section('content');
    }

    public function setLockerCode()
    {
        $this->locker_code = $this->locker_id;
    }
    public function checkDuplicate()
    {
        $locker = ModelsLocker::where('locker_id',$this->locker_id)->first();
        if(isset($locker)){
            $this->duplicate_locker = true;
            $this->message = "Duplicate Locker";
        }else{
            $this->duplicate_locker = false;
        }
    }
    
    public function selectCompany($id)
    {
        $selectedCompany = Company::where('company_id',$id)->first();
        $this->selectedCompany_code = $selectedCompany->code;
        // dd($this->selectedCompany_code);
    }
    public function selectCountry($id)
    {
        $selectedCountry = Country::find($id);
        $this->selectedCountry_code = $selectedCountry->country_code;
        // dd($this->selectedCompany_code);
    }
    public function clearInputField()
    {
        $this->locker_id = '';
        $this->locker_code = '';
        $this->division_id = '';
        $this->district_id = '';
        $this->upazilla_id = '';
        $this->union_id = '';
        $this->locker_landmark = '';
        $this->display_resolutions = '';
    }
    public function findDistrict($id)
    {
        $selectedDivision = Division::find($id);
        $this->selectedDivision_code = $selectedDivision->code;

        $this->district = District::where('division_id', $id)->get();
    }
    public function findUpazila($id)
    {
        $this->upazila = Upazila::where('district_id', $id)->get();
    }
    public function findUnion($id)
    {
        $this->union = Union::where('upazilla_id', $id)->get();
    }

    public function locker_save()
    {
        $this->validate([
            'locker_id' => 'required|unique:lockers',
            'locker_code' => 'required|unique:lockers',
            'division_id' => 'required|not_in:0',
            'display_resolution_id' => 'required|not_in:0'
        ], [
            "locker_id.required" => 'Locker ID required',
            "locker_code.required" => 'Locker Code required',
            "division_id.required" => 'Please select division',
            "display_resolution_id.required" => 'Please select locker display resolution',
        ]);

        $locker = new ModelsLocker();
        $locker->locker_id = $this->locker_id;
        $locker->locker_code = $this->locker_code;
        $location_ids = [
            'country_id'    => $this->selectedCountryID,
            'company_id'    => $this->selectedCompanyID,
            'division_id'   => $this->division_id,
            'extra_code'    => $this->extra_code,
            'detail'        => $this->setExtraLocationIdsForSearch(),
        ];
        $locker->location_ids = json_encode($location_ids);
        $locker->location_address = $this->address;
        $locker->display_resolution = $this->display_resolution_id;
        $locker->location_landmark = $this->locker_landmark;

        

        if ($locker->save()) {
            return redirect()->route('superAdmin.addLocker')->with('message', 'New Locker Create Successfully!!');
        }
    }

    /**
     * 
     *  Make Address comma separator
     */
    public function address()
    {
        $div_name = Division::where('id', $this->division_id)->first();
        $this->div_name = $div_name->name;
        if ($this->district_id) {
            $district_name = District::where('id', $this->district_id)->first();
            $this->district_name = $district_name->name;
        }
        if ($this->upazilla_id) {
            $upazila_name = Upazila::where('id', $this->upazilla_id)->first();
            $this->upazila_name = $upazila_name->name;
        }
        if ($this->union_id) {
            $union_name = Union::where('id', $this->union_id)->first();
            $this->union_name = $union_name->name;
        }

        $data = $this->div_name . ', ' . $this->district_name . ', ' . $this->upazila_name . ', ' . $this->union_name;
        $data = rtrim($data, ", ");
        return $data;
    }

    public function setExtraLocationIdsForSearch()
    {
        if($this->selectedCountryID){
            $selectedCountry = Country::where('id', $this->selectedCountryID)->first();
            $this->country_name = strtolower($selectedCountry->country_name);
        }
        if($this->selectedCompanyID){
            $selectedCompany = Company::where('company_id', $this->selectedCompanyID)->first();
            $this->company_name = strtolower($selectedCompany->company_name);
        }
        
        if($this->division_id){
            $div_name = Division::where('id', $this->division_id)->first();
            $this->div_name = strtolower($div_name->name);
        }
        if ($this->district_id) {
            $district_name = District::where('id', $this->district_id)->first();
            $this->district_name = strtolower($district_name->name);
        }
        if ($this->upazilla_id) {
            $upazila_name = Upazila::where('id', $this->upazilla_id)->first();
            $this->upazila_name = strtolower($upazila_name->name);
        }
        if ($this->union_id) {
            $union_name = Union::where('id', $this->union_id)->first();
            $this->union_name = strtolower($union_name->name);
        }

        $data = [
            "company" => $this->company_name,
            "country" => $this->country_name,
            "division" => $this->div_name,
            "district" => $this->district_name,
            "upazilla" => $this->upazila_name,
            "union" => $this->union_name,
        ];
        // $data = $this->div_name . ', ' . $this->district_name . ', ' . $this->upazila_name . ', ' . $this->union_name;
        // $data = rtrim($data, ", ");
        return $data;
    }
}
