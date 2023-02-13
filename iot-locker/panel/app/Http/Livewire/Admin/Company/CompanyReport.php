<?php

namespace App\Http\Livewire\Admin\Company;

use App\Exports\Company as ExportsCompany;
use App\Exports\CompanyReport as ExportsCompanyReport;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Locker;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class CompanyReport extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $dateForReport, $today, $active = 0, $company_name, $company_locations, $selectedLocation,
        $company_report_search_text,
        $company_report_search_text2,
        $asc_desc = false, $page_no = 10,
        $company, $userRole, $userId, $selectedStatus,
        $total_booked_by_date, $collected_by_date, $not_collected_by_date, $returned_by_date,
        $dateRangeShow, $dateRange;

    public $todayTotalCollected,
        $todayTotalPending,
        $todayTotalReturn,
        $totalBooking,
        $start_date,
        $end_date,
        $total_booked_by_date_obj,
        $company_search_text,
        $pre_booking,
        $preBooked,
        $dateForPrebooked;

    protected $listeners = ['setDateRange'];


    public function mount()
    {
        $company = Company::where('company_id', Auth::user()->company_id)->first();

        $this->company = $company;
        $this->company_locations = $company->lockers;
        $this->company_name = $company->company_name;
        $this->today = Carbon::now()->format('D');
        $this->dateForReport = Carbon::now();

        // User Role For Locker list
        $this->userRole = Auth::user()->role->role_slug;
        $this->userId = Auth::user()->id;

        $this->dateRange = null;

        $this->dateForPrebooked = Carbon::now()->subDays(0)->format('Y-m-d');
    }

    public function setDateRange($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->dateRangeShow = $start_date . ' - ' . $end_date;
        $this->dateRange = [date($this->start_date), date($this->end_date)];

        $this->active = -1;
    }

    public function render()
    {
        if ($this->userRole === 'company-admin' || $this->userRole === 'super-admin') {
            $lockers = Locker::where('company_id', $this->company->id)
                ->where('location_is_active', 1)
                ->get();
        } else {
            $loggedInUser =  User::where('id',  $this->userId)->with(['lockers' => function ($query) {
                $query->where('is_active', 1);
            }])->first();
            $lockers = $loggedInUser->lockers; //here locakers is the locations (DB)
            // dd($lockers->pluck('locker_id'));
        }
        $locker_ids = $lockers->pluck('locker_id');


        $bookings = Booking::searchBookingForCompanyReport($this->company_report_search_text, $this->company_report_search_text2)
            ->where('company_id', $this->company->company_id)
            ->where('soft_deleted_at', null)
            ->whereIn('locker_id', $locker_ids)
            ->when(is_null($this->dateRange), function ($q) {
                $q->whereDate("created_at", $this->dateForReport);
            })
            ->when($this->dateRange, function ($q) {
                $q->whereBetween('created_at', $this->dateRange);
            })
            ->when($this->selectedLocation, function ($q) {
                $q->where('locker_id', $this->selectedLocation);
            })
            ->when($this->selectedStatus == 'not_collected', function ($q) {
                $q->whereNull('collected_by');
            })
            ->when($this->selectedStatus == 'collected', function ($q) {
                $q->whereNotNull('collected_by')
                    // ->where('is_max_pickup_time_passed', 0) //cause they need only customer-collects
                    ->where('booking_is_returned', 0); //cause they need only customer-collects
            })
            ->when($this->selectedStatus == 'returned', function ($q) {
                // $q->where('is_max_pickup_time_passed', 1);
                $q->Where('booking_is_returned', 1);
            })
            ->when($this->selectedStatus == 'returned_by_agent', function ($q) {
                $q->where('is_max_pickup_time_passed', 0);
                $q->Where('booking_is_returned', 1); //only return by agent (Emergency Open)
            })

            
            ->paginate($this->page_no);

        // dd($bookings);
        // Calculate Booking,Collected Count.
        $this->total_booked_by_date_obj = Booking::searchBookingForCompanyReport($this->company_report_search_text, $this->company_report_search_text2)
            ->where('company_id', $this->company->company_id)
            ->where('soft_deleted_at', null)
            ->whereIn('locker_id', $locker_ids)
            ->when($this->selectedLocation, function ($q) {
                $q->where('locker_id', $this->selectedLocation);
            })->when(is_null($this->dateRange), function ($q) {
                $q->whereDate("created_at", $this->dateForReport);
            })->when(!is_null($this->dateRange), function ($q) {
                $q->whereBetween('created_at', $this->dateRange);
            })->get();

        // dd($this->total_booked_by_date_obj);

        $this->total_booked_by_date = $this->total_booked_by_date_obj->count();


        $this->not_collected_by_date = Booking::searchBookingForCompanyReport($this->company_report_search_text, $this->company_report_search_text2)
            ->where('company_id', $this->company->company_id)
            ->where('soft_deleted_at', null)
            ->whereIn('locker_id', $locker_ids)
            ->when($this->selectedLocation, function ($q) {
                $q->where('locker_id', $this->selectedLocation);
            })
            ->whereNull('collected_by')
            ->when(is_null($this->dateRange), function ($q) {
                $q->whereDate("created_at", $this->dateForReport);
            })->when(!is_null($this->dateRange), function ($q) {
                $q->whereBetween('created_at', $this->dateRange);
            })->count();


        // $this->collected_by_date = $this->total_booked_by_date - $this->not_collected_by_date;
        $this->collected_by_date = $this->total_booked_by_date_obj->whereNotNull('collected_by')
            ->where('is_max_pickup_time_passed', 0)
            ->where('booking_is_returned', 0)
            ->count();

        $this->returned_by_date = $this->total_booked_by_date_obj->whereNotNull('collected_by')
            // ->where('is_max_pickup_time_passed', 1)
            ->Where('booking_is_returned', 1) //error showing orWhere
            ->count();

        // By date
        // dd($total_booked);
        $totalBooking = Booking::searchBookingForCompanyReport($this->company_report_search_text, $this->company_report_search_text2)
            ->where('company_id', $this->company->company_id)
            ->where('soft_deleted_at', null)
            ->whereIn('locker_id', $locker_ids)
            ->when($this->selectedLocation, function ($q) {
                $q->where('locker_id', $this->selectedLocation);
            })->get();



        $this->todayTotalCollected = Booking::searchBookingForCompanyReport($this->company_report_search_text, $this->company_report_search_text2)
            ->where('company_id', $this->company->company_id)
            ->where('soft_deleted_at', null)
            ->whereIn('locker_id', $locker_ids)
            ->when($this->selectedLocation, function ($q) {
                $q->where('locker_id', $this->selectedLocation);
            })
            ->whereNotNull('collected_by')
            ->when(is_null($this->dateRange), function ($q) {
                $q->whereDate("collected_at", $this->dateForReport);
            })
            ->when(!is_null($this->dateRange), function ($q) {
                $q->whereBetween('collected_at', $this->dateRange);
            })->count();

        // dd($this->dateForReport,$this->todayTotalCollected);
        // dd($tmp_totalBooking->count());

        $this->todayTotalPending = $totalBooking->whereNull('collected_by')
            ->count();

        $this->preBooked = $totalBooking->where('created_at', '<', $this->dateForPrebooked)
            ->whereNull('collected_by')
            ->count();

            // dd($this->dateForPrebooked,$this->todayTotalPending,$this->preBooked);
            // dd($this->dateForPrebooked,$this->todayTotalPending,$this->preBooked);

        // dd($this->todayTotalPending,$this->preBooked);


        $this->todayTotalReturn = Booking::searchBookingForCompanyReport($this->company_report_search_text, $this->company_report_search_text2)
            ->where('company_id', $this->company->company_id)
            ->where('soft_deleted_at', null)
            ->whereIn('locker_id', $locker_ids)
            ->when($this->selectedLocation, function ($q) {
                $q->where('locker_id', $this->selectedLocation);
            })
            ->where('booking_is_returned', 1)
            ->when(is_null($this->dateRange), function ($q) {
                $q->whereDate("updated_at", $this->dateForReport);
            })
            ->when(!is_null($this->dateRange), function ($q) {
                $q->whereBetween('updated_at', $this->dateRange);
            })
            ->count();

        // dd($this->todayTotalReturn);

        Session::put('bookings', $bookings);


        return view('livewire.admin.company.company-report', ['bookings' => $bookings, "lockers" => $lockers])
            ->extends('master')
            ->section('content');
    }

    public function setDateForReport($numberOfsubDays)
    {
        $this->dateRange = null;
        $this->dateForReport = Carbon::now()->subDays($numberOfsubDays);
        $this->dateForPrebooked = Carbon::now()->subDays($numberOfsubDays)->format('Y-m-d');
        $this->active = $numberOfsubDays;
    }


    public function todayReturn()
    {
        // $this->selectedStatus = 'returned';

        // $numberOfsubDays = 4;
        // $this->dateRange = Carbon::now()->subDays($numberOfsubDays) - Carbon::now()->subDays($numberOfsubDays);
        // $this->dateForReport = $this->dateForReport->subDays($numberOfsubDays);
        // $this->active = $numberOfsubDays;
    }

    public function clearSearch()
    {
        $this->company_search_text = '';
    }
    // Excel export company data
    public function Export()
    {
        return Excel::download(new ExportsCompanyReport, $this->company_name . '_report_' . $this->dateForReport . '.xlsx');
    }

    // Company data pdf export
    public function ExportPdf()
    {
        return Excel::download(new ExportsCompanyReport,  $this->company_name . '_report_' . $this->dateForReport . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    // Company data csv export
    public function ExportCSV()
    {
        return Excel::download(new ExportsCompanyReport,  $this->company_name . '_report_' . $this->dateForReport . '.csv');
    }
}
