<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Company;
use App\Models\EventLog;
use App\Models\Locker;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;


class DashboardLogs extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $userId, $user, $company_id, $userRole;
    public $search_text,
        $page_no = 10,
        $selected_locations = [],
        $user_all_locations = [],
        $orderBy = 'id',
        $asc_desc = 'desc', $filterIconClass,
        $eventLog_category = null;

    public $what, $detail, $who, $when, $start_date, $end_date, $dateRange;
    protected $listeners = ['setLocation', 'unSetLocation', 'setDateRange'];
    protected $eventLogs;

    public function mount()
    {
        $this->userId = Auth::user()->id;
        $this->user = User::where('id', $this->userId)->first();
        $company = Company::where('company_id', $this->user->company_id)->first();
        $this->company_id = $company->id;
        // User Role For Locker list
        $this->userRole = Auth::user()->role->role_slug;


        if ($this->userRole === 'company-admin' || $this->userRole === 'super-admin' || $this->userRole == "locker-master") {
            $lockers = Locker::where('company_id', $this->company_id)
                ->where('location_is_active', 1)
                ->get();
            $this->user_all_locations = $lockers->pluck('locker_id')->toArray();
        } else {
            $this->user_all_locations = $this->user->lockers->pluck('locker_id')->toArray();
        }





        // $this->selected_locations = $this->user_all_locations;
        if (session()->has('selectedLocationForFilter')) {
            $this->selected_locations = [Session::get('selectedLocationForFilter')];
        } else {
            if (count($this->user_all_locations)) {
                $this->selected_locations = [$this->user_all_locations[0]];
            } else {
                $this->selected_locations = [];
            }
        }

        // $this->start_date = date("Y-m-d");
        // $this->end_date = date("Y-m-d");
        // $this->when = $this->start_date.' - '.$this->end_date;
        $this->when = null;
    }



    public function render()
    {
        // dd($this->userRole);
        if ($this->userRole == "locker-master") {
            $this->eventLog_category = "locker-master-activity";
        }
        // dd($this->eventLog_category);

        $this->eventLogs = EventLog::searchLogData($this->search_text, $this->what, $this->detail, $this->who, $this->dateRange)
            ->whereIn('log_location_id', $this->selected_locations)
            ->when($this->eventLog_category, function ($q) {
                $q->where('log_event_category', $this->eventLog_category);
            })
            ->orderBy($this->orderBy, $this->asc_desc)
            ->with('box', 'box.bookings')
            ->paginate($this->page_no);

        // dd($this->eventLogs);

        if (
            $this->search_text != null || $this->what != null ||
            $this->detail != null || $this->dateRange != null || $this->who != null
        ) {
            $this->resetPage();
        }

        return view('livewire.dashboard.dashboard-logs', ['eventLogs' => $this->eventLogs]);
    }

    public function setLocation($location)
    {
        $this->selected_locations = [$location];
        if (count($this->selected_locations) == count($this->user_all_locations)) {
            // $this->selected_locations = [];
        }

        // if (!in_array($location, $this->selected_locations)) {
        //     array_push($this->selected_locations, $location);
        // }
    }
    public function unSetLocation($location)
    {
        if (in_array($location, $this->selected_locations)) {
            unset($this->selected_locations[array_search($location, $this->selected_locations)]);
            Session::put('selectedLocationForFilter', "");
        }
        if (!count($this->selected_locations)) {
            $this->selected_locations = $this->user_all_locations;
        }
        // $this->selected_locations = $this->user_all_locations;
        // $this->selected_location = null;
        // $this->emit('unSetLocation');
    }

    public function setDateRange($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->when = $start_date . ' - ' . $end_date;
        $this->dateRange = [date($this->start_date), date($this->end_date)];
    }

    public function activityRowClick($box_id)
    {
        # code...
    }
}
