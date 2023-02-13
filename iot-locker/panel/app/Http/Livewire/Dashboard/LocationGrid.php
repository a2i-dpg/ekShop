<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Box;
use App\Models\Company;
use App\Models\Locker;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class LocationGrid extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $userId, $user, $userRole, $loggedInUser, $selected_locker_ids;

    public $onlineTime = 0,
        $searchLocation = null,
        $company_id,
        $locationData,
        $allLockersIds,
        $location_ids;

    public function newActivity()
    {
        $this->onlineTime = 1;
    }

    public function mount()
    {

        $this->userId = Auth::user()->id;
        $this->user = User::where('id', $this->userId)->first();
        $company = Company::where('company_id', $this->user->company_id)->first();
        $this->company_id = $company->id;
        $this->userRole = Auth::user()->role->role_slug;
        $this->selected_locker_ids = [];

        $this->searchLocation = null;


        // Copy from render-start
        if ($this->userRole === 'company-admin' || $this->userRole === 'super-admin' || $this->userRole === 'locker-master') {
            $this->locationData = Locker::search($this->searchLocation)
                ->where('location_is_active', 1)
                ->where('company_id', $this->company_id)
                ->get();
            // dd($locationData);
        } else {
            // dd($this->userId);
            // Logged User
            $this->loggedInUser =  User::where('id',  $this->userId)->with(['lockers' => function ($query) {
                $query->where('is_active', 1);
            }])->first();
            $this->locationData = $this->loggedInUser->lockers; //here lockers is the locations (DB)
        }
        $this->allLockersIds = $this->locationData->pluck('locker_id');
        // dd($this->allLockersIds);


        // Copy from render-end
        if (session()->has('selectedLocationForFilter')) {
            $this->filterByLocation(Session::get('selectedLocationForFilter'));
        } else {
            if (count($this->allLockersIds)) {
                Session::put('selectedLocationForFilter', $this->allLockersIds[0]);
                $this->filterByLocation($this->allLockersIds[0]);
            } else {
                dd("No Locker Found for this user");
            }
        }

        // $this->filterByLocation($this->allLockersIds[0]);
    }

    public function render()
    {
        // dd($this->searchLocation);
        if (isset($this->searchLocation)) {
            $this->searchBy();
        }
        return view('livewire.dashboard.location-grid', ['locationData' => $this->locationData]);
    }


    public function searchBy()
    {
        if ($this->userRole === 'company-admin' || $this->userRole === 'super-admin' || $this->userRole === 'locker-master') {
            $this->locationData = Locker::search($this->searchLocation)
                ->where('location_is_active', 1)
                ->where('company_id', $this->company_id)
                ->get();
        } else {
            // Agent
            $this->loggedInUser =  User::where('id',  $this->userId)->with(['lockers' => function ($query) {
                $query->where('is_active', 1);
            }])->first();
            $this->location_ids = $this->loggedInUser->lockers->pluck('locker_id');
            $this->locationData = Locker::search($this->searchLocation)
                ->where('location_is_active', 1)
                ->whereIn('locker_id', $this->location_ids)
                ->get();
            // dd("agent-locker-ids",$this->location_ids);
            // $this->locationData = $this->loggedInUser->lockers;
        }

        $this->allLockersIds = $this->locationData->pluck('locker_id');
        // dd($this->allLockersIds);
    }

    public function filterByLocation($locationId)
    {
        // dd(count($this->selected_locker_ids));
        if (count($this->selected_locker_ids) && in_array($locationId, $this->selected_locker_ids)) {
            $this->selected_locker_ids = [];
            $this->emit('setLocation', null);
            Session::put('selectedLocationForFilter', "");
            $this->emit('getALlBoxes', true);
        } else {
            $this->selected_locker_ids = [$locationId];
            $this->emit('setLocation', $locationId);
            Session::put('selectedLocationForFilter', $locationId);
            $this->emit('getALlBoxes', false);
        }
    }

    public function getALlBoxes()
    {
        $this->emit('getALlBoxes', true);
    }

    // public function showBox($id)
    // {
    //     $singleBoxData = Box::where('id', $id)->with('locker')->first();
    //     $this->box_key = $singleBoxData->box_key;
    //     $this->box_no = $singleBoxData->box_no;
    //     $this->box_location = $singleBoxData->locker->location_address;
    //     $this->locker_id = $singleBoxData->locker->locker_id;
    //     if (empty($singleBoxData->locker->location_landmark)) {
    //         $this->location_landmark = 'N/A';
    //     } else {
    //         $this->location_landmark = $singleBoxData->locker->location_landmark;
    //     }
    //     $this->box_size = $singleBoxData->box_size;
    //     if ($singleBoxData->box_is_online == 0) {
    //         $this->box_is_online = 'Offline';
    //     } else {
    //         $this->box_is_online = 'Online';
    //     }
    //     if ($singleBoxData->box_is_enable == 0) {
    //         $this->box_is_enable = 'Disable';
    //     } else {
    //         $this->box_is_enable = 'Enable';
    //     }
    //     if ($singleBoxData->box_is_in_maintenance == 0) {
    //         $this->box_is_maintenance = 'Running';
    //     } else {
    //         $this->box_is_maintenance = 'Maintenance';
    //     }
    //     if ($singleBoxData->box_is_booked == 0) {
    //         $this->box_is_booked = 'Empty';
    //     } else {
    //         $this->box_is_booked = 'Booked';
    //     }
    // }
}
