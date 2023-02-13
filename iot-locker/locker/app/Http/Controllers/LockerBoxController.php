<?php

namespace App\Http\Controllers;

use App\Events\BoxInsertEvent;
use App\Events\MessageInsertEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Box;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LockerBoxController extends Controller
{
    private $LocalLocationData;

    function __construct()
    {
        $this->LocalLocationData = Location::first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boxes = Box::orderBy(DB::raw('LENGTH(box_no), box_no'))->get();
        return view('locker-box.index', ['boxes' => $boxes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request->box_no)) {
            $request['box_no'] = 'Box-' . $request->box_no;
        }

        $request->validate(
            [
                'box_no' => 'required|unique:boxes',
                'boxsize' => 'required',
            ],
            [
                'box_no.required' => 'The box number field is required.',
                'box_no.unique' => 'The box number has already been taken.',
            ]
        );

        $input['box_location_id'] = $this->LocalLocationData->location_id;
        $input['box_key'] = $this->LocalLocationData->location_id . '-' . Str::random(4);
        $input['box_no'] = $request->box_no;
        $input['box_size'] = $request->boxsize;

        $boxResponse = Box::create($input);
        if ($boxResponse) {
            event(new BoxInsertEvent($boxResponse));
        }

        return redirect()->route('locker-box.index')->with('success', 'Box Added Successfully');
    }

    public function lockerBoxCreateMultiple()
    {
        $boxes = Box::orderBy(DB::raw('LENGTH(box_no), box_no'))->get();
        return view('locker-box.create-multiple', ['boxes' => $boxes]);
    }

    public function lockerBoxCreateMultipleSubmit(Request $request)
    {
        $request->validate(
            [
                'box_no_from' => 'required|numeric',
                'box_no_to' => 'required|numeric',
                'boxsize' => 'required',
            ],
            [
                'box_no_from.required' => 'The Box From field is required.',
                'box_no_to.required' => 'The Box To field is required.',
                'box_no_from.numeric' => 'Box number must be a number.',
                'box_no_to.numeric' => 'Box number must be a number.',
            ]
        );

        if (($request->box_no_to - $request->box_no_from) < 1) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'To must be greater than From');
        }

        $box_no_from = $request->box_no_from;
        $box_no_to   = $request->box_no_to;

        for ($box_no_from = $box_no_from; $box_no_from <= $box_no_to; $box_no_from++) {
            $box_no = 'Box-' . $box_no_from;

            $boxExist = Box::where('box_no', $box_no)->first();

            if (isset($boxExist)) {
                return redirect()
                    ->back()
                    ->with('error', $box_no . ' already exist');
            }

            $input['box_location_id'] = $this->LocalLocationData->location_id;
            $input['box_key'] = $this->LocalLocationData->location_id . '-' . Str::random(4);
            $input['box_no'] = 'Box-' . $box_no_from;
            $input['box_size'] = $request->boxsize;

            $boxResponse = Box::create($input);
            if ($boxResponse) {
                event(new BoxInsertEvent($boxResponse));
            }
        }

        return redirect()->route('locker-box.create-multiple')->with('success', 'Box Added Successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $box_info = Box::find($id);
        $boxes = Box::all();
        return view('locker-box.edit', ['box_info' => $box_info, 'boxes' => $boxes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (isset($request->box_no)) {
            $request['box_no'] = 'Box-' . $request->box_no;
        }
        $request->validate(
            [
                'box_no' => 'required|unique:boxes,box_no,' . $id,
                'boxsize' => 'required',
            ],
            [
                'box_no.required' => 'The box number field is required.',
                'box_no.unique' => 'The box number has already been taken.',
            ]
        );

        $input['box_no'] = $request->box_no;
        $input['box_size'] = $request->boxsize;

        $box_info = BOX::find($id);
        $response = $box_info->update($input);

        return redirect()->route('locker-box.index')->with('success', 'Box Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteConfirmationSubmit(Request $request)
    {
        dd($request->all());
        // $response = Box::find($id)->delete();

        // if ($response) {
        //     return redirect()->route('locker-box.index')->with('success', 'Box deleted successfully');
        // }
    }

    public function destroy($id)
    {
        $response = Box::find($id)->delete();
        return response()->json($response);
    }

    public function lockerBoxMaintenance(Request $request)
    {
        $input['box_is_enable']         = isset($request->box_is_enable);
        $input['box_is_in_maintenance'] = isset($request->box_is_in_maintenance);

        if ($request->box_is_enable == false) {
            $input['box_is_online'] = false;
            $input['box_is_offline_at'] = Carbon::now()->format('Y-m-d-H:i:s');
        } else {
            if ($request->box_is_in_maintenance == true) {
                return redirect()->route('locker-box.index')->with('error', 'If you want to Enable, Box \'s Maintenance must be disabled');
            }
        }

        $box_info = BOX::find($request->box_id);
        $response = $box_info->update($input);

        return redirect()->route('locker-box.index')->with('success', 'Box Updated Successfully');
    }
}
