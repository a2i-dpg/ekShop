<?php

use App\Http\Controllers\AgentDashboardController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportBookingController;
use App\Http\Controllers\LockerMasterController;
use App\Http\Livewire\AddSettings;
use App\Http\Livewire\Admin\AddDelivery;
use App\Http\Livewire\Admin\AdminDashboard;
use App\Http\Livewire\Admin\Agent\AddAgent;
use App\Http\Livewire\Admin\Agent\AllAdmin;
use App\Http\Livewire\Admin\Agent\AllAgent;

use App\Http\Livewire\Admin\Agent\ExportImportBooking;
use App\Http\Livewire\Admin\Allbooking;
use App\Http\Livewire\Admin\AllDeliveryMan;
use App\Http\Livewire\Admin\Company\CompanyReport;
use App\Http\Livewire\Admin\DigiDashboard;
use App\Http\Livewire\Admin\Settings\AddImages;
use App\Http\Livewire\Analysis\BookingAnalysis;
use App\Http\Livewire\Analysis\LockerAnalysis;
use App\Http\Livewire\Analysis\ReportAnalysis;
use App\Http\Livewire\ApiSecret;
use App\Http\Livewire\BookingData;
use App\Http\Livewire\BookingSms;
use App\Http\Livewire\ChangePassword;
use App\Http\Livewire\CreateLocation;
use App\Http\Livewire\GenerelSettings;
use App\Http\Livewire\LocalAdmin;
use App\Http\Livewire\Myaccount;
use App\Http\Livewire\ParcelTracker;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Locker;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



// Route::get('/test',[HomeController::class,'test']);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/time-test", function () {
    return Carbon::now()->format('Y-m-d H:i:s');
});

// Route::get("/latest-booking/{number}", function ($number) {
//     // return "hello";
//     $latestBooking = Booking::orderBy('collected_at', 'DESC')->limit($number)->get();
//     return $latestBooking;
// });
// Route::get("/latest-booking-by-date/{date}", function ($date) {
//     // return "hello";
//     $latestBooking = Booking::whereDate('collected_at', $date)->get();
//     return $latestBooking;
// });

// Route::get("/test", function () {
//     $user = Auth::user();
//     $rawData = [
//         "booking" => "booking obj",
//         "category" => "booking",
//         "sub_category" => "input_customer_number",
//         "description" => "Customer number input by <b>$user->user_name</b> <br> ($user->user_mobile_no)",
//     ];
//     // dd($rawData);
//     $formatedData = EventLogHelper::formatData($rawData);
//     dd($formatedData);

//     $latestBooking = Booking::orderBy('collected_at', 'DESC')->limit(20)->get();
//     return $latestBooking;

//     $newBooking = new Booking();
//     $newBooking->booking_id = "1234";
//     $newBooking->box_id = "1234";
//     $newBooking->locker_id = "1234";
//     $newBooking->parcel_no = "1234";
//     $newBooking->booked_by_user_id = "az_2";
//     $newBooking->company_id = "er_ds1";
//     $newBooking->booked_at = Carbon::now();

//     $newBooking->customer_no = "1234";
//     $newBooking->save();
//     dd($newBooking);

//     $company = Company::where('company_id', Auth::user()->company_id)->first();
//     $company_locations = $company->lockers;
//     return $company_locations;

//     $userId = Auth::user()->id;
//     $user = User::where('id', $userId)->first();
//     $company = Company::where('company_id', $user->company_id)->first();
//     $lockers = Locker::where('company_id', $company->id)
//         ->get();
//     return $lockers;
// });
// Route::get("/sync-test",[SyncedController::class,'getUserInfo']);

// Home Routing Without authentication
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [HomeController::class, 'login'])->name('login');
    Route::post('user/login', [HomeController::class, 'user_login'])->name('user.login');
});

// Logout Route
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');

/**
 * 
 * All User
 */
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile-setting', Myaccount::class)->name('common.myAccount');
    Route::get('/change-password', ChangePassword::class)->name('common.changePassword');
});


// Route For SuperAdmin 
Route::group(['prefix' => 'super-admin', 'middleware' => ['superAdmin', 'auth']], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('superAdmin.home');
    Route::get('/create-company', \App\Http\Livewire\Company::class)->name('superAdmin.createCompany');
    Route::get('/all-company', \App\Http\Livewire\CompanyView::class)->name('superAdmin.allCompany');
    Route::get('/add-locker', \App\Http\Livewire\Locker::class)->name('superAdmin.addLocker');
    Route::get('/all-locker', \App\Http\Livewire\LockerView::class)->name('superAdmin.allLocker');
    Route::get('/all-settings', GenerelSettings::class)->name('superAdmin.settings');
    Route::get('/add-assets', AddSettings::class)->name('superAdmin.addAssets');
    Route::get('/add-images', AddImages::class)->name('superAdmin.addImages');
    Route::get('/add-api-secret', ApiSecret::class)->name('superAdmin.addApiSecret');
    Route::get('/add-local-admin', LocalAdmin::class)->name('superAdmin.addLocalAdmin');
    Route::get('/create-location', CreateLocation::class)->name('superAdmin.createLocation');
    Route::get('/all-booking-list', BookingData::class)->name('superAdmin.allBookingData');
    Route::get('/all-booking-sms-list', BookingSms::class)->name('superAdmin.allBookingSms');

    //compy from company-admin route:group
    Route::get('/add-delivery-man', AddDelivery::class)->name('superAdmin.addDeliveryMan');
    Route::get('/all-delivery-man', AllDeliveryMan::class)->name('superAdmin.allDeliveryMan');
});

// Route For Company Admin
Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth']], function () {
    Route::redirect('/', '/admin/dashboard', 302);
    Route::get('/dashboard', [HomeController::class, 'admin_index'])->name('admin.home');
    Route::get('/admin-dashboard', AdminDashboard::class)->name('admin.dashboard');
    
    Route::get('/iotLocker-dashboard', DigiDashboard::class)->name('iotLocker.dashboard');
    
    Route::get('/company-report', CompanyReport::class)->name('admin.company-report');


    Route::get('/add-delivery-man', AddDelivery::class)->name('admin.addDeliveryMan');
    Route::get('/all-delivery-man', AllDeliveryMan::class)->name('admin.allDeliveryMan');
    Route::get('/all-booking-lists', Allbooking::class)->name('admin.allBooking');

    // Admin & Agent
    Route::get('/add-agent', AddAgent::class)->name('admin.addAgent');
    Route::get('/all-agent', AllAgent::class)->name('admin.allAgent');
    Route::get('/all-admin', AllAdmin::class)->name('admin.allAdmin');


    
    Route::get('/analysis-booking', BookingAnalysis::class)->name('admin.analysisBooking');
    Route::get('/report-analysis', ReportAnalysis::class)->name('admin.reportAnalysis');
    Route::get('/analysis-locker', LockerAnalysis::class)->name('admin.analysis-locker');
});

// Company Agent
Route::group(['prefix' => 'agent', 'middleware' => ['auth'], 'as' => 'agent.'], function () {
    Route::redirect('/', '/agent/dashboard', 302);
    Route::get('/dashboard', [AgentDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/export-import-bookings', ExportImportBooking::class)->name('exportImportBooking');
    Route::post('booking-import-for-customer-number', [ImportBookingController::class, 'bookingImportForCustomerNumber'])->name('bookingImportForCustomerNumber');

    // Report For Booking 7 Days
    Route::get('/company-report', CompanyReport::class)->name('company-report');

    // SMS resend page
    Route::get('/all-booking-sms-list', BookingSms::class)->name('allBookingSms');
});

Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
    Route::post('/submit-customer-number', [AjaxController::class, 'submitCustomerNumber'])->name('submitCustomerNumber');
});



Route::get('/parcel-tracker', ParcelTracker::class)->name('parcelTracker');
