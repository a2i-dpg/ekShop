<?php

namespace App\Http\Livewire;

use App\Events\SmsCheck;
use App\Helpers\SendSms;
use App\Jobs\ResendSMS;
use App\Models\Company;
use App\Models\Locker;
use App\Models\MessageLog;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BookingSms extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search_text,
        $orderBy = 'id',
        $asc_desc = false,
        $page_no = 10,
        $user_role,
        $showMessage = false,
        $selectedLocation = null,
        $lockers, $loggedInUser_locker_ids;

    public function mount()
    {
        $this->user = Auth::user();
        $this->user_role = Role::find(Auth::user()->role_id);

        $this->company = Company::where('company_id', $this->user->company_id)->first();
        // dd($this->company);
        if ($this->user_role->role_slug == "super-admin") {
            //Super-Admin
            $this->lockers = Locker::orderBy('id')
                ->where('location_is_active', 1)
                ->get();
            $this->loggedInUser_locker_ids = $this->lockers->pluck('locker_id');
        } else if ($this->user_role->role_slug == "company-admin") {

            //company-Admin
            $this->lockers = Locker::where('company_id', $this->company->id)
                ->where('location_is_active', 1)
                ->orderBy('id')
                ->get();
            $this->loggedInUser_locker_ids = $this->lockers->pluck('locker_id');
        }

        // ($this->user_role->role_slug == "company-agent")
        else {
            // company-agent
            $loggedInUser =  User::where('id',  $this->user->id)->with(['lockers' => function ($query) {
                $query->where('is_active', 1);
            }])
                ->with('riders')
                ->first();

            $this->lockers = $loggedInUser->lockers; //here locakers is the locations (DB)
            $this->loggedInUser_locker_ids = $this->lockers->pluck('locker_id');
            // dd($this->loggedInUser_locker_ids);
            // $this->riders = $loggedInUser->riders()->paginate($this->page_no);
        }
    }
    public function render()
    {

        $bookingSms = MessageLog::search($this->search_text)
            ->where('event_name', 'box booking')
            ->when($this->selectedLocation == null, function ($q) {
                $q->whereIn('locker_id', $this->loggedInUser_locker_ids);
            })
            ->when($this->selectedLocation, function ($q) {
                $q->where('locker_id', $this->selectedLocation);
            })
            ->with('locker')
            ->with('booking')
            ->orderBy($this->orderBy, $this->asc_desc ? 'asc' : 'desc')
            ->paginate($this->page_no);

        // dd($bookingSms);

        $this->showMessage = false;

        if ($this->user_role->role_slug == "super-admin") {
            //Super-Admin
            $this->showMessage = true;
        } else if ($this->user_role->role_slug == "company-admin") {
            $this->showMessage = false;
        }
        //($this->user_role->role_slug == "company-agent") 
        else {
            // company-agent
            $this->showMessage = false;
        }

        return view('livewire.booking-sms', ['bookingSms' => $bookingSms])
            ->extends('master')
            ->section('content');
    }

    public function clearSearch()
    {
        $this->search_text = '';
        $this->orderBy = 'id';
        $this->asc_desc = false;
    }

    public function resend($id)
    {
        $MessageLog = MessageLog::where('id', $id)->first();
        $details = [
            'body' => $MessageLog->sms_text,
            'mobile' => $MessageLog->receiver_number
        ];

        // dd(Carbon::now()->format('Y-m-d H:i:s'));

        $message = SendSms::sendSms($details['mobile'], $details['body']);
        if ($message->code != 200) {
            session()->flash('error', $message->reason);
        } else {
            $MessageLog->resend_count = (int)$MessageLog->resend_count + 1;
            $retryTimes = [];
            if (!is_null($MessageLog->resend_times)) {
                $retryTimes = $MessageLog->resend_times;
                $retryTimes = json_decode($retryTimes);
            }

            // dd(json_decode($retryTimes));

            $retryTimes[] = Carbon::now()->format('Y-m-d H:i:s');
            $retryTimes = json_encode($retryTimes);
            $MessageLog->resend_times = $retryTimes;

            $MessageLog->save();
            session()->flash('success', 'Message sent successfully');
        }
    }
}
