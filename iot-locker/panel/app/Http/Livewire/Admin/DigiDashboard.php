<?php

namespace App\Http\Livewire\Admin;

use App\Models\Locker;
use Carbon\Carbon;
use Livewire\Component;

class DigiDashboard extends Component
{
    public $totalboxes,
    $activeBoxes;

    public function mount(){

    }

    public function render()
    {
        $this->totalboxes = Locker::whereHas('company',function($company){
            $company->where('company_id', session('company_id'));
        })
        ->where('location_is_active',1)
        ->count();

        $offlineTimeMinutes  = 30;
        $dateTime = Carbon::now()->subMinute($offlineTimeMinutes)->format('Y-m-d H:i:s');

        

        $this->activeBoxes = Locker::whereHas('company',function($company){
            $company->where('company_id', session('company_id'));
        })
        ->where('location_is_active',1)
        ->where('last_online_at','>',$dateTime)
        ->count();

        // dd($this->activeBoxes );


        return view('livewire.admin.digi-dashboard')->extends('master')
        ->section('content');
    }
}
