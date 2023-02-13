<?php

use App\Events\SmsEvent;
use App\Helpers\EventLog;
use App\Http\Controllers\AdminMaintenanceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SynchronizeDataController;
use App\Http\Controllers\LockerBoxController;

use App\Http\Controllers\DeliveryMan\UserDeliveryManLoginController;
use App\Http\Controllers\DeliveryMan\BoxBookingController;
use App\Http\Controllers\OperationalController;
use App\Http\Controllers\ReceiverVerificationController;
use App\Http\Controllers\ReturnBookingController;
use App\Http\Controllers\VideoController;

use App\Models\Booking;
use App\Models\Box;
use App\Models\Location;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Str;

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

Route::get('/test-today', function () {
});

Route::get('/test-loader', function () {
    return view('test-loader');
})->name('test-loader');

//Application route start from here

//Operational task
Route::get('/', [OperationalController::class, 'sliderPage'])->name('slider-page');
Route::get('/offline', [OperationalController::class, 'offline'])->name('offline');

Route::post('/switch-language', [OperationalController::class, 'switchLanguage']);
Route::post('/update-single-box-open-status', [OperationalController::class, 'updateSingleBoxOpenStatus']);
Route::post('/get-all-box', [OperationalController::class, 'getAllBox']);
Route::post('/update-box-is-closed', [OperationalController::class, 'updateBoxIsClosed']);
Route::get('/inform-to-supervisor', [OperationalController::class, 'informToSupervisor']);

Route::get('/dashboard', function () {
    Auth::logout();
    return view('landing-page');
})->name('fend.dashboard');

Route::get('/admin', function () {
    return redirect('/admin/login');
});

Route::fallback(function () {
    return redirect()->route('slider-page');
});

//Route for admin role
Route::prefix('admin')->group(function () {

    Route::group(['middleware' => ['admin', 'auth']], function () {

        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
        Route::get('/location-settings', [SettingsController::class, 'LocationSettings'])->name('settings.location');
        Route::post('/location-settings', [SettingsController::class, 'LocationSettingsSubmit'])->name('settings.location');

        Route::get('/synchronize-data', [SynchronizeDataController::class, 'index'])->name('synchronize-data');
        Route::get('/synchronize-company', [SynchronizeDataController::class, 'synchronizeCompanyData'])->name('synchronize-company');
        Route::get('/synchronize-location', [SynchronizeDataController::class, 'synchronizeLocationData'])->name('synchronize-location');
        Route::get('/synchronize-assets', [SynchronizeDataController::class, 'synchronizeAssetsData'])->name('synchronize-assets');
        Route::get('/synchronize-users', [SynchronizeDataController::class, 'synchronizeUsersData'])->name('synchronize-users');

        Route::post('/locker-box/maintenance', [LockerBoxController::class, 'lockerBoxMaintenance'])->name('locker-box.maintenance');
        Route::get('/locker-box/create-multiple', [LockerBoxController::class, 'lockerBoxCreateMultiple'])->name('locker-box.create-multiple');
        Route::post('/locker-box/create-multiple', [LockerBoxController::class, 'lockerBoxCreateMultipleSubmit'])->name('locker-box.create-multiple');
        Route::resource('/locker-box', LockerBoxController::class);

        Route::get('/video', [VideoController::class, 'videoUpload'])->name('video');
        Route::post('/video', [VideoController::class, 'videoUploadSubmit'])->name('video');

        Route::get('/maintenance', [AdminMaintenanceController::class, 'index'])->name('maintenance');
        Route::get('/maintenance/checkOtp', [AdminMaintenanceController::class, 'checkOtp'])->name('checkOtp');
        Route::get('/maintenance/getOtp', [AdminMaintenanceController::class, 'getOtp'])->name('getOtp');
    });

    Auth::routes();
});

//Route for Deliveryman role

Route::get('/login', [UserDeliveryManLoginController::class, 'index'])->name('deliveryman.login');
Route::post('/login', [UserDeliveryManLoginController::class, 'loginFormSubmin'])->name('deliveryman.login');
Route::get('/alternative-login', [UserDeliveryManLoginController::class, 'alternativeLogin'])->name('deliveryman.alternative-login');
Route::post('/send-otp', [UserDeliveryManLoginController::class, 'sendOTP'])->name('deliveryman.send-otp');
Route::get('/send-otp', [UserDeliveryManLoginController::class, 'sendOTPSubmitForm'])->name('deliveryman.send-otp');
Route::post('/submit-otp', [UserDeliveryManLoginController::class, 'submitOTP'])->name('deliveryman.submit-otp');

Route::group(['middleware' => ['deliveryman', 'auth']], function () {

    Route::get('/boxlist', [BoxBookingController::class, 'index'])->name('deliveryman.boxlist');
    Route::get('/size-wise-boxlist', [BoxBookingController::class, 'sizeWiseBoxList'])->name('deliveryman.size-wise-boxlist');
    Route::get('/legend-wise-boxlist', [BoxBookingController::class, 'legendWiseBoxList'])->name('deliveryman.legend-wise-boxlist');
    Route::get('/box-booking', [BoxBookingController::class, 'boxBooking'])->name('deliveryman.box-booking');
    Route::post('/box-booking', [BoxBookingController::class, 'boxBookingSubmit'])->name('deliveryman.box-booking');
    Route::get('/booking-confirmed', [BoxBookingController::class, 'bookingConfirmed']);
    Route::get('/booking-cancel', [BoxBookingController::class, 'bookingCancel']);

    Route::get('/box-booking-counter', [BoxBookingController::class, 'boxBookingCounter'])->name('deliveryman.box-booking-counter');
    Route::get('/inform-delivery-man', [BoxBookingController::class, 'informDeliveryMan']);

    Route::get('/box-booking-return', [ReturnBookingController::class, 'boxBookingReturn'])->name('deliveryman.box-booking-return');
    Route::post('/box-booking-return', [ReturnBookingController::class, 'boxBookingReturnSubmit'])->name('deliveryman.box-booking-return');

    Route::get('/emergency_box_open', [ReturnBookingController::class, 'emergencyBoxOpen'])->name('deliveryman.emergency_box_open');
    Route::post('/emergency_box_open', [ReturnBookingController::class, 'emergencyBoxOpenSubmit'])->name('deliveryman.emergency_box_open');
    Route::post('/incorrect-placed-parcel-pickup-confirmed', [ReturnBookingController::class, 'incorrectPlacedParcelPickupConfirmed']);
    Route::post('/thank-you-message-for-error-placed-parcel', [ReturnBookingController::class, 'thankYouMsgForErrorPlacedParcel']);

    Route::get('/delivery-man-pickup-confirmed', [ReturnBookingController::class, 'deliveryManPickupConfirmed']);
    Route::get('/thank-you-message-for-delivery-man', [ReturnBookingController::class, 'thankYouMsg']);
    Route::get('/inform-return-delivery-man', [ReturnBookingController::class, 'informReturnDeliveryMan']);

    Route::get('/skip-returned-list', [ReturnBookingController::class, 'skipReturnedList'])->name('deliveryman.skip-returned-list');
    Route::get('/skip-emergencyboxopen-list', [ReturnBookingController::class, 'skipEmergencyBoxOpenList'])->name('deliveryman.skip-emergencyboxopen-list');
});

//Route for Customer role
Route::get('/verification', [ReceiverVerificationController::class, 'verificationForm'])->name('verification');

//(Not use now)
Route::get('/verification-otp', [ReceiverVerificationController::class, 'verificationOTP'])->name('verification-otp');
Route::post('/verification-otp', [ReceiverVerificationController::class, 'verificationOTPSubmit'])->name('verification-otp');

Route::group(['middleware' => ['customer']], function () {
    Route::post('/verification', [ReceiverVerificationController::class, 'verificationFormSubmit'])->name('verification');
    Route::post('/verification-barcode', [ReceiverVerificationController::class, 'verificationBarcodeFormSubmit'])->name('verification-barcode');
    Route::get('/verify-receiver-info', [ReceiverVerificationController::class, 'verifyReceiverInfo'])->name('verify-receiver-info');
    Route::post('/verify-with-parcel', [ReceiverVerificationController::class, 'verifyWithParcelSubmit'])->name('verify-with-parcel');
    Route::get('/verify-company-otp', [ReceiverVerificationController::class, 'verifyCompanyOTP'])->name('verify-company-otp');
    Route::post('/verify-company-otp', [ReceiverVerificationController::class, 'verifyCompanyOTPSubmit'])->name('verify-company-otp');
    Route::post('/receiver-pickup-confirmed', [ReceiverVerificationController::class, 'receiverPickupConfirmed']);

    Route::post('/thank-you-message-for-customer', [ReceiverVerificationController::class, 'thankYouMsg']);

    Route::get('/inform-customer-and-supervisor', [ReceiverVerificationController::class, 'informCustomerAndSupervisor']);
});

//For Crown Job
Route::get('/sync-box-local2cloud', [SynchronizeDataController::class, 'syncBoxLocal2Cloud']);
Route::get('/sync-booking-local2cloud', [SynchronizeDataController::class, 'syncBookingLocal2Cloud']);
Route::get('/sync-message-local2cloud', [SynchronizeDataController::class, 'syncMessageLocal2Cloud']);
Route::get('/sync-event-log-local2cloud', [SynchronizeDataController::class, 'syncEventLogLocal2Cloud']);

Route::get('/sync-assets-cloud2local', [SynchronizeDataController::class, 'syncAssetsCloud2Local']);
Route::get('/sync-company-cloud2local', [SynchronizeDataController::class, 'syncCompanyCloud2Local']);
Route::get('/sync-user-cloud2local', [SynchronizeDataController::class, 'syncUserCloud2Local']);

Route::get('/sync-return-booking-cloud2local', [SynchronizeDataController::class, 'syncReturnBookingCloud2Local']);
Route::get('/sync-boxes-cloud2local', [SynchronizeDataController::class, 'syncBoxesCloud2Local']);  //Need to set convention for particular box if needed
