<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $LocalLocationData;

    public function __construct()
    {
        $this->middleware('auth');
        $this->LocalLocationData = Location::first();
    }

    public function index()
    {
        if (isset($this->LocalLocationData)) {
            return view('dashboard', ['location' => $this->LocalLocationData]);
        }
        return redirect()->route('settings.location');
    }
}
