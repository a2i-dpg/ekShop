<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Country;
use App\Models\DisplayResolution;
use App\Models\District;
use App\Models\Division;
use App\Models\Locker;
use App\Models\LockerRider;
use App\Models\LockerUser;
use App\Models\Union;
use App\Models\Upazila;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Carbon;
use Livewire\Component;

class LockerView extends Component
{
    public $locker_list,
        $locker_is_active,
        $location_landmark,
        $locker_id,
        $locker_code,
        $address,
        $current_id,
        $delete_id = '',
        $locker_for_dlete,
        $display_resolutions,
        $display_resolution_id,
        $duplicate_locker,
        $selectedCountryID,
        $selectedCompanyID,
        $generateUniqueID = false,
        $division_id,
        $extra_code,
        $district_id,
        $upazilla_id,
        $union_id,
        $country_name,
        $company_name,
        $div_name,
        $district_name,
        $upazila_name,
        $union_name,
        $selectedCountry_code,
        $selectedCompany_code,
        $message,
        $district,
        $selectedDivision_code,
        $lockerStatus,
        $prev_locker_id;



    public function render()
    {
        $this->countries = Country::whereIn('country_code', ["BD", "IN"])->get();
        $this->division = Division::all();
        $this->companies = Company::all();

        $this->locker_list = Locker::orderby('created_at', 'desc')->get();
        $this->display_resolutions = DisplayResolution::all();

        if ($this->generateUniqueID) {
            $this->generateUniqueID();
        }

        return view('livewire.locker-view')
            ->extends('master')
            ->section('content');
    }
    public function lockerEdit($id)
    {
        $findLocker = Locker::findOrFail($id);
        $this->current_id = $id;
        $this->locker_id = $findLocker->locker_id;
        $this->prev_locker_id = $findLocker->locker_id; //for query with the actual locker id before edit
        $this->locker_code = $findLocker->locker_code;
        $this->location_landmark = $findLocker->location_landmark;
        $this->address = $findLocker->location_address;
        $this->locker_is_active = $findLocker->location_is_active;
        $this->display_resolution_id = $findLocker->display_resolution;
        $this->lockerStatus = $findLocker->location_is_active;

        $location_ids = json_decode($findLocker->location_ids);
        // dd($findLocker);
        if (isset($location_ids->country_id)) {
            $this->selectedCountryID = $location_ids->country_id;
            $this->selectedCompanyID = $location_ids->company_id;
            $this->division_id = $location_ids->division_id;
            
            $this->extra_code = $location_ids->extra_code;

            $selectedCountry = Country::find($this->selectedCountryID);
            $this->selectedCountry_code = $selectedCountry->country_code;

            $selectedCompany = Company::where('company_id', $this->selectedCompanyID)->first();
            $this->selectedCompany_code = $selectedCompany->code;

            $selectedDivision = Division::where('id', $this->division_id)->first();
            $this->selectedDivision_code = $selectedDivision->code;
        } else {
            // dd("no country code");
        }
    }

    public function locker_update()
    {
        
        $location_ids = [
            'country_id'    => $this->selectedCountryID,
            'company_id'    => $this->selectedCompanyID,
            'division_id'   => $this->division_id,
            'extra_code'    => $this->extra_code,
            'detail'        => $this->setExtraLocationIdsForSearch(),
        ];

        // dd("update");

        $updateArray =  [
            'locker_code' => $this->locker_code,
            'location_landmark' => $this->location_landmark,
            'location_is_active' => $this->lockerStatus,
            'location_address' => $this->address,
            'display_resolution' => $this->display_resolution_id,
            'location_ids' => $location_ids,
        ];

        
        
        $updateArray['locker_id'] = $this->locker_id;

        $hasError = false;
        $message = 'Data Update Successfully';
        $previousLocker = Locker::where('locker_id', $this->prev_locker_id)
            ->with('users')
            ->with('riders')
            ->with('boxes')
            ->with('bookings')
            ->first();

            
        if (count($previousLocker->users) && $this->prev_locker_id != $this->locker_id) {

            $hasError = true;
            unset($updateArray["locker_id"]);
            $err_message = 'Locker ID not Update Cause **users connected';
        }
        if (count($previousLocker->riders) && $this->prev_locker_id != $this->locker_id) {

            $hasError = true;
            unset($updateArray["locker_id"]);
            $err_message = 'Locker ID not Update Cause **riders connected';
        }
        if (count($previousLocker->boxes) && $this->prev_locker_id != $this->locker_id) {

            $hasError = true;
            unset($updateArray["locker_id"]);
            $err_message = 'Locker ID not Update Cause **boxes connected';
        }
        if (count($previousLocker->bookings) && $this->prev_locker_id != $this->locker_id) {

            $hasError = true;
            unset($updateArray["locker_id"]);
            $err_message = 'Locker ID not Update Cause **bookings connected';
        }



        
        Locker::where('id', $this->current_id)
            ->update($updateArray);

        // Toastr::success('message','Data Update Successfully');

        if ($hasError) {
            return redirect()->route('superAdmin.allLocker')
                ->with("message", $message)
                ->with("error", $err_message);
        } else {
            return redirect()->route('superAdmin.allLocker')->with("message", $message);
        }
    }


    public function findDistrict($id)
    {
        $selectedDivision = Division::find($id);
        $this->selectedDivision_code = $selectedDivision->code;

        $this->district = District::where('division_id', $id)->get();
        $this->generateUniqueID = true;
    }

    public function checkDuplicate()
    {
        $locker = Locker::where('locker_id', $this->locker_id)->first();
        if (isset($locker)) {
            $this->duplicate_locker = true;
            $this->message = "Duplicate Locker";
        } else {
            $this->duplicate_locker = false;
        }
    }

    public function selectCompany($id)
    {
        $selectedCompany = Company::where('company_id', $id)->first();
        $this->selectedCompany_code = $selectedCompany->code;
        $this->generateUniqueID = true;
    }
    public function selectCountry($id)
    {
        $selectedCountry = Country::find($id);
        $this->selectedCountry_code = $selectedCountry->country_code;
        $this->generateUniqueID = true;
    }

    public function setLockerCode()
    {
        $this->locker_code = $this->locker_id;
    }

    public function setExtraCode()
    {
        $this->generateUniqueID = true;
    }

    // generate locker unique id
    public function generateUniqueID()
    {
        $this->locker_id = null;

        if (isset($this->selectedCountry_code)) {
            $this->locker_id = "DG" . $this->selectedCountry_code;
        }
        if (isset($this->selectedCompany_code)) {
            $this->locker_id = $this->locker_id . "" . $this->selectedCompany_code;
        }
        if (isset($this->selectedDivision_code)) {
            $this->locker_id = $this->locker_id . "-" . $this->selectedDivision_code;
        }
        if (isset($this->extra_code)) {
            // $this->extra_code = strtoupper($this->extra_code);
            $this->locker_id = $this->locker_id . "" . strtoupper($this->extra_code);
        }

        $this->setLockerCode();
        $this->checkDuplicate();
    }

    public function deleteID($id)
    {
        $this->delete_id = $id;
        $locker = Locker::find($id);
        $this->locker_for_dlete = $locker->locker_id;
    }
    public function delete()
    {
        $deleteLocker = Locker::where('id', $this->delete_id)->first();
        if (isset($deleteLocker)) {
            // Delete all relations
            $lockerRider = LockerRider::where('locker_id', $deleteLocker->id)->delete();
            $lockerUser = LockerUser::where('locker_id', $deleteLocker->id)->delete();
            $deleteLocker->delete();
        }
        session()->flash('delete', 'Locker (' . $this->locker_for_dlete . ') Removed Successfully');
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
