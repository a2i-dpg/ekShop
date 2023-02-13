<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Booking;
use App\Models\Box;
use App\Models\Company;
use App\Models\Locker;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class DashboardBookingBoxes extends Component
{
    public $locker_ids = [], $user_all_locker_ids = [], $getALlBoxes;
    public $user, $userRole, $company_id, $showTotalBoxSizeDetails = 0;

    protected $listeners = ['setLocation', 'unSetLocation', 'getALlBoxes'];
    public $boxes, $hideAndShow = 'hide', $filterIconClass = 'fe-filter',
        $totalBox, $smallBox, $mediumBox, $largeBox;

    public $box_is_enable = [0, 1],
        $box_is_booked = [0, 1],
        $box_is_in_maintenance = [0, 1],
        $box_is_closed = [0, 1];

    public $newBooking = 0, $is_max_pickup_time_passed = 0;

    public $boxId, $bgColorOfBadge, $show_disable_boxes = 0;

    public function mount()
    {
        $this->getALlBoxes = false;

        $this->user = User::where('id', Auth::id())->first();

        $company = Company::where('company_id', $this->user->company_id)->first();
        $this->company_id = $company->id;
        // User Role For Locker list
        $this->userRole = Auth::user()->role->role_slug;

        if ($this->userRole === 'company-admin' || $this->userRole === 'super-admin') {
            $lockers = Locker::where('company_id', $this->company_id)
                ->where('location_is_active', 1)
                ->get();
            $this->user_all_locker_ids = $lockers->pluck('locker_id')->toArray();
        } else {
            $this->user_all_locker_ids = $this->user->lockers->pluck('locker_id')->toArray();
        }

        // $this->user_all_locker_ids = $user->lockers->pluck('locker_id')->toArray();
        // $this->locker_ids = $this->user_all_locker_ids;

        if (session()->has('selectedLocationForFilter')) {
            $this->locker_ids = [Session::get('selectedLocationForFilter')];
        } else {
            $this->locker_ids = [$this->user_all_locker_ids[0]];
        }
    }

    public function render()
    {
        // dd("Booking Boxes");
        // $allBox = Box::whereIn('locker_id', $this->locker_ids)->get();

        if ($this->newBooking) {
            $this->boxes = Box::whereHas('bookings', function ($query) {
                $query->whereNull('customer_no')
                    ->where('booking_is_returned', 0);
            })
                ->whereIn('locker_id', $this->locker_ids)
                ->whereIn('box_is_enable', $this->box_is_enable)
                ->whereIn('box_is_booked', $this->box_is_booked)
                ->whereIn('box_is_closed', $this->box_is_closed)
                ->with('bookings')
                ->get();
        } elseif ($this->is_max_pickup_time_passed) {
            // dd("else if");
            // $this->boxes = Box::whereHas('bookings', function ($query) {
            //     $query->whereDate('updated_at', '>=', Carbon::now()->subDays(1))
            //     ->where('is_max_pickup_time_passed', 1)
            //     ->whereNotNull('collected_by');
            // })
            //     ->whereIn('locker_id', $this->locker_ids)
            //     ->whereIn('box_is_enable', $this->box_is_enable)
            //     ->whereIn('box_is_booked', $this->box_is_booked)
            //     ->whereIn('box_is_closed', $this->box_is_closed)

            //     ->with('bookings')
            //     ->get();
            // dd($this->boxes);

            // dd(Carbon::now());

            $to = Carbon::now()->format('Y-m-d');
            $from = Carbon::now()->subDays(7)->format('Y-m-d');
            /**Code for returned-booking boxes */
            $returnedBookingsBoxIds = Booking::whereIn('locker_id', $this->locker_ids)
                ->whereBetween("booked_at", [$from,$to])
                ->where('is_max_pickup_time_passed', 1)
                ->where('booking_is_returned', 0)
                ->whereNull('collected_at')
                ->pluck('box_id')
                ->toArray();

            $this->boxes = Box::whereIn('box_key', $returnedBookingsBoxIds)
                ->with('bookings')
                ->get();
        } else {
            // dd("ok");
            // This is main query
            if ((sizeof($this->box_is_enable) == 1)) {
                $this->boxes = Box::whereIn('locker_id', $this->locker_ids)
                    ->whereIn('box_is_enable', $this->box_is_enable)
                    ->where('box_is_booked', 0)
                    // ->whereIn('box_is_in_maintenance', $this->box_is_in_maintenance)
                    ->where('box_is_in_maintenance', 0)
                    ->whereIn('box_is_closed', $this->box_is_closed)
                    ->with('bookings')
                    ->get();
            } else {
                if ($this->show_disable_boxes == 1) {
                    $this->boxes = Box::whereIn('locker_id', $this->locker_ids)
                        ->where('box_is_enable', 0)
                        ->with('bookings')
                        ->get();
                } else {
                    $this->boxes = Box::whereIn('locker_id', $this->locker_ids)
                        ->whereIn('box_is_enable', $this->box_is_enable)
                        ->whereIn('box_is_booked', $this->box_is_booked)
                        ->whereIn('box_is_in_maintenance', $this->box_is_in_maintenance)
                        ->whereIn('box_is_closed', $this->box_is_closed)
                        ->with('bookings')
                        ->get();
                    // ->paginate(10);
                }
            }
        }

        $this->totalBox = $this->boxes->count();
        $this->smallBox = $this->boxes->where('box_size', 'small')->count();
        $this->mediumBox = $this->boxes->where('box_size', 'medium')->count();
        $this->largeBox = $this->boxes->where('box_size', 'large')->count();

        // $this->boxes = $this->boxes->getQuery();
        // dd($this->boxes->query());

        if ($this->getALlBoxes) {
            $this->boxes = [];
        }

        return view('livewire.dashboard.dashboard-booking-boxes', ['boxes' => $this->boxes]);
    }

    public function setCustomerMobileNo($box_id)
    {
        if ($box_id) {
            $this->boxId = $box_id;
        } else {
            $this->boxId = 0;
        }
        // $this->emit('setBoxId',$box_id);
        $this->emit('showRightModal', $box_id);
    }

    public function showDisabledBoxes()
    {
        $this->emptyFilter();
        $this->show_disable_boxes = 1;
    }

    public function setLocation($location)
    {
        if ($location != null) {
            $this->locker_ids = [$location]; //for single location select only
        } else {
            $this->locker_ids = $this->user_all_locker_ids; //for single location select only
        }

        $this->showTotalBoxSizeDetails = 0;
        // if(count($this->locker_ids) == count($this->user_all_locker_ids)){
        //     $this->locker_ids = [];
        // }

        // if (!in_array($location, $this->locker_ids)) {
        //     array_push($this->locker_ids, $location);
        // }
    }
    public function unSetLocation($location)
    {
        if (in_array($location, $this->locker_ids)) {
            unset($this->locker_ids[array_search($location, $this->locker_ids)]);
            Session::put('selectedLocationForFilter', "");
        }
        if (!count($this->locker_ids)) {
            $this->locker_ids = $this->user_all_locker_ids;
        }

        $this->getALlBoxes(true);
    }

    public function getALlBoxes($trueFalse)
    {
        $this->getALlBoxes = $trueFalse;
    }

    public function emptyFilter()
    {
        $this->newBooking = 0;
        $this->is_max_pickup_time_passed = 0;

        $this->box_is_enable = [0, 1];
        $this->box_is_booked = [0, 1];
        $this->box_is_in_maintenance = [0, 1];
        $this->box_is_closed = [0, 1];
        $this->box_is_closed = [0, 1];

        $this->bgColorOfBadge = '';

        $this->show_disable_boxes = 0;

        $this->setHideAndSHow();
    }

    public function showNewBooking()
    {
        $this->emptyFilter();
        $this->bgColorOfBadge = 'new-booking';
        $this->newBooking = !$this->newBooking;
    }
    public function showEnable()
    {
        $this->emptyFilter();
        $this->bgColorOfBadge = 'enable';
        (sizeof($this->box_is_enable) > 1) ? $this->box_is_enable = [1] : $this->box_is_enable = [0, 1];
    }
    public function showBooked()
    {
        $this->emptyFilter();
        $this->bgColorOfBadge = 'booked';
        (sizeof($this->box_is_booked) > 1) ? $this->box_is_booked = [1] : $this->box_is_booked = [0, 1];
    }
    public function showMaintenence()
    {
        $this->emptyFilter();
        $this->bgColorOfBadge = 'mainenance';
        (sizeof($this->box_is_in_maintenance) > 1) ? $this->box_is_in_maintenance = [1] : $this->box_is_in_maintenance = [0, 1];
    }
    public function showOpen()
    {
        $this->emptyFilter();
        $this->bgColorOfBadge = 'box_open';
        (sizeof($this->box_is_closed) > 1) ? $this->box_is_closed = [0] : $this->box_is_closed = [0, 1];
    }
    public function showReturn()
    {
        $this->emptyFilter();
        $this->bgColorOfBadge = 'box_open';
        $this->is_max_pickup_time_passed = !$this->is_max_pickup_time_passed;
    }

    public function setHideAndSHow()
    {
        ($this->hideAndShow == "hide") ? $this->hideAndShow = "show" : $this->hideAndShow = "hide";
        ($this->filterIconClass == "fe-filter") ? $this->filterIconClass = "fe-delete" : $this->filterIconClass = "fe-filter";
    }

    public function showTotalBoxSizeDetails()
    {
        $this->showTotalBoxSizeDetails = !$this->showTotalBoxSizeDetails;
    }
}
