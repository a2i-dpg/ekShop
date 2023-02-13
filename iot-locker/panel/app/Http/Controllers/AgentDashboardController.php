<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentDashboardController extends Controller
{
    public function dashboard()
    {
        // return "agent Dashboard";
        return view('templates.agent_dashboard');
    }
}
