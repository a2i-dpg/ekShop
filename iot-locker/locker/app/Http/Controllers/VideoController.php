<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Box;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    private $LocalLocationData;

    function __construct()
    {
        $this->LocalLocationData = Location::first();
    }

    public function videoUpload()
    {
        if (!isset($this->LocalLocationData)) {
            return redirect()->route('settings.location');
        }
        $booking = Booking::where('is_max_pickup_time_passed', 1)
            ->where('booking_collected_by', '=', null)
            ->get();

        if (count($booking) < 1) {
            return redirect()->route('deliveryman.boxlist');
        }

        return view('video', ['booking' => $booking]);
    }

    public function videoUploadSubmit(Request $request)
    {
        dd($request->all());
        $filename = '';
        $filepath = '';
        if ($request->hasFile('demo-video') && $request->file('demo-video')->isValid()) {

            $filename = $request->input('demo-video');
            $filepath = $request->file('images')->store('products');
            dd($filepath);
        }
        dd('outside');

        $input = $request->all();
        $input['created_by'] = 1;
        $input['img_url'] = $filepath;
    }
}
