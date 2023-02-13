<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Company;
use App\Models\DisplayResolution;
use App\Models\GenerelSettings;
use App\Models\Locker;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AddImages extends Component
{
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ["image_save", "save_priority"];

    public $setting_value_img = [],
        $assetsUrlForImages,
        $locations = [],
        $page_no = 10,
        $selected_location = null,
        $locker_id,
        $locationForupload,
        $settingTypeForUpload,
        $settingDisplayResolutionForUpload,
        $display_resolutions;

    public function mount()
    {
        $this->assetsUrlForImages = asset('storage') . '/';
        $user = User::where('id', Auth::user()->id)->with('lockers')->first();
        $userRole = Auth::user()->role->role_slug;

        $company = Company::where('company_id', $user->company_id)->first();

        if ($userRole == 'super-admin') {
            $locationData = Locker::where('location_is_active', 1)
                ->get();
            foreach ($locationData as $key => $location) {
                array_push($this->locations, $location->locker_id);
            }
        } elseif ($userRole == 'company-admin') {
            $locationData = Locker::where('company_id', $this->$company->id)
                ->where('location_is_active', 1)
                ->get();
            foreach ($locationData as $key => $location) {
                array_push($this->locations, $location->locker_id);
            }
        } else {
            foreach ($user->lockers as $key => $location) {
                array_push($this->locations, $location->locker_id);
            }
        }
    }

    public function render()
    {
        $this->display_resolutions = DisplayResolution::all();

        $allLogos = GenerelSettings::when($this->selected_location, function ($query) {
            $query->where('locker_id', $this->selected_location);
        })->when($this->settingTypeForUpload, function ($query) {
            $query->where('setting_name', $this->settingTypeForUpload);
        })->when($this->settingDisplayResolutionForUpload, function ($query) {
            $query->where('display_resolution_id', $this->settingDisplayResolutionForUpload);
        })->orderBy('priority', 'asc')
            ->paginate($this->page_no);

        // if (!is_null($this->selected_location)) {
        //     $allLogos = GenerelSettings::where('locker_id', $this->selected_location)
        //         ->orderBy('priority', 'asc')
        //         ->paginate($this->page_no);
        // } else {
        //     $allLogos = GenerelSettings::where('locker_id', $this->locations)
        //         ->orderBy('priority', 'asc')
        //         ->paginate($this->page_no);
        // }

        return view('livewire.admin.settings.add-images', ['allLogos' => $allLogos])
            ->extends('master')
            ->section('content');
    }

    public function image_save()
    {
        if (!isset($this->settingTypeForUpload) || !isset($this->selected_location) || !isset($this->settingDisplayResolutionForUpload)) {
            session()->flash('error', 'Type, Location & Display is required');
            return false;
        }
        if ($this->setting_value_img) {
            foreach ($this->setting_value_img as $key => $image) {
                $setting = new GenerelSettings();
                $setting->setting_name = $this->settingTypeForUpload;
                $setting->locker_id = $this->selected_location;
                $setting->settings_id = 'setting' . '' . Str::random(4);
                $setting->setting_value = $image->store('images', 'public');
                $setting->display_resolution_id = $this->settingDisplayResolutionForUpload;
                $setting->save();
            }
        }
        $this->clearInput();
        session()->flash('success', 'Images add successfully');
    }
    public function save_priority($id, $priority_number)
    {
        $general_setting = GenerelSettings::find($id);
        $general_setting->priority = $priority_number;
        $general_setting->update();
    }
    public function clearInput()
    {
        // $this->setting_name = '';
        // $this->setting_value = '';
        $this->setting_value_img = '';
    }

    public function deleteImage($id)
    {
        $general_setting = GenerelSettings::find($id);
        $general_setting->delete();
        session()->flash('success', 'Image deleted successfully');
    }
}
