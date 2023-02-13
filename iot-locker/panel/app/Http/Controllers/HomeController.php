<?php

namespace App\Http\Controllers;

use App\Helpers\ValidateNumber;
use App\Helpers\Variables;
use App\Models\Booking;
use App\Models\Box;
use App\Models\Company;
use App\Models\GenerelSettings;
use App\Models\Locker;
use App\Models\Rider;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
    protected $redirectTo;
    /**
     * 
     * Login functionality
     */
    public function user_login(Request $request)
    {
        $login = request()->input('userName');

        if (is_numeric($login)) {
            $field = 'user_mobile_no';
        } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'user_name';
        }
        request()->merge([$field => $login]);

        foreach ($request as $key => $value) {
            unset($request['userName']);
        }
        if (isset($request->email)) {

            $attr = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string|min:5'
            ]);
        } else if (isset($request->user_mobile_no)) {
            $attr = $request->validate([
                'mobile' => 'required|string|digits:11',
                'password' => 'required|string|min:5'
            ]);
        } else {
            $attr = $request->validate([
                'user_name' => 'required|string',
                'password' => 'required|string|min:5'
            ]);
        }

        if (!Auth::attempt($attr)) {
            return redirect()->route('login')->withInput()->with('message', 'Username or password not match');
        } else {
            Session::put('user_id', Auth::user()->id);
            Session::put('role_id', Auth::user()->role_id);
            Session::put('company_id', Auth::user()->company_id);
            if (Auth::user()->role->role_slug === 'super-admin') {
                Toastr::success('Login Successful', 'login');
                return redirect()->route('superAdmin.home');
            } else if (Auth::user()->role->role_slug === 'company-admin' && Auth::user()->user_is_active === 1) {
                return redirect()->route('admin.home');
            } else if (Auth::user()->role->role_slug === 'company-agent' && Auth::user()->user_is_active === 1) {
                return redirect()->route('agent.dashboard');
            }else if (Auth::user()->role->role_slug === 'locker-master' && Auth::user()->user_is_active === 1) {
                return redirect()->route('lm.dashboard');
            }else if (Auth::user()->role->role_slug === 'company-admin' && Auth::user()->user_is_active === 0) {
                Session::flush();
                return redirect()->route('login');
            }
        }
    }
    public function login()
    {
        return view('user_login.login');
    }
    
    public function index()
    {

        $pickedData = Booking::select(DB::raw('count(*) as `data`'), DB::raw('YEAR(created_at) year, MONTH(created_at) month'), DB::raw('company_id'))
            ->where('collected_by', null)
            ->where('collected_at', '!=', null)
            ->with('company')
            ->groupby('month', 'year', 'company_id')
            ->get();
        return view('templates.index', compact('pickedData'));
    }
    /***
     * 
     * Auth Logout
     */
    public function logout()
    {
        Auth::logout();
        Session::flush();
        Toastr::success('Logout Successful', 'logout');
        return redirect()->route('login');
    }


    /**
     * 
     * Admin Or Company Home view
     */
    public function admin_index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $package = Booking::where('booked_at', '>=', $today . ' 00:00:00')
            ->where('company_id', session('company_id'))
            ->paginate(10);

        $totalBooking = Booking::where('company_id', session('company_id'))
            ->count();

        $pickedBooking = Booking::where('company_id', session('company_id'))
            ->whereNotNull('collected_at')
            ->whereNotNull('collected_by')
            ->where('is_max_pickup_time_passed', 0)
            ->count();

        $pendingBooking = Booking::where('company_id', session('company_id'))
            ->whereNull('collected_at')
            ->whereNull('collected_by')
            ->count();


        $returnedBook = Booking::where('company_id', session('company_id'))
            ->whereNotNull('collected_at')
            ->whereNotNull('collected_by')
            ->where('is_max_pickup_time_passed', 1)
            ->count();

        $totalDeliveryMan = Rider::where('role_id', Variables::deliveryManRole)
            ->where('company_id', session('company_id'))
            ->count();
        $totalAgent = User::where('role_id', Variables::companyAgentRole)
            ->where('company_id', session('company_id'))
            ->count();
        $totalAdmin = User::where('role_id', Variables::companyAdminRole)
            ->where('company_id', session('company_id'))
            ->count();

        $totalboxes = Locker::whereHas('company',function($company){
            $company->where('company_id', session('company_id'));
        })
        ->where('location_is_active',1)
        ->count();

        $offlineTimeMinutes  = 30;
        $dateTime = Carbon::now()->subMinute($offlineTimeMinutes)->format('Y-m-d H:i:s');

        $activeBoxes = Locker::whereHas('company',function($company){
            $company->where('company_id', session('company_id'));
        })
        ->where('location_is_active',1)
        ->where('last_online_at','>',$dateTime)
        ->count();

        

        return view('templates.admin_index', compact(
            'package',
            'totalBooking',
            'pickedBooking',
            'returnedBook',
            'totalDeliveryMan',
            'pendingBooking',
            'totalAgent',
            'totalAdmin',
            'totalboxes',
            'activeBoxes'
        ));
    }
}
