<?php

namespace App\Http\Controllers;

use App\Imports\BookingImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ImportBookingController extends Controller
{
    public function bookingImportForCustomerNumber(Request $request)
    {
        // dd($request->all());
        // return "OK";
        $import = Excel::import(new BookingImport, $request->file('file')->store('temp'));

        // dd($import);
        
        if(Session::has('errorCheckMessage')){
            $errorCheckMessage = Session::get('errorCheckMessage');
            // dd($errorCheckMessage);
            return back()->with('message',$errorCheckMessage);
        }
        $dataChangeCounter = 0;
        if(Session::has('dataChangeCounter')){
            $dataChangeCounter = Session::get('dataChangeCounter');
        }

        
        
        return back()->with('message',$dataChangeCounter.' coustomer numbers imported successfully');
    }
}
