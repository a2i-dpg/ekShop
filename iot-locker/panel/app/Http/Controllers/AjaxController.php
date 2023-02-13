<?php

namespace App\Http\Controllers;

use App\Helpers\ValidateNumber;
use App\Models\Booking;
use Carbon\Carbon;
use EventLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function submitCustomerNumber(Request $request)
    {
        return response()->json([
            'status' => 200,
            'message' => "Succesfully Inserted Customer Number",
            'data' => 'text data'
        ], 200);
    }
}
