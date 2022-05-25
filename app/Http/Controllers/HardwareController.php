<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\Room;
use Illuminate\Http\Request;

class HardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $hardwares = Hardware::with('room')->get();
        return view('hardwares.index', compact('hardwares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $rooms = Room::whereStatus(1)->whereType(1)->get();
        return view('hardwares.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // return $request;
        try {
            $hardware = Hardware::create($request->except('_token'));
            if($hardware) {
                return redirect()->route('hardwares.index')->with('success', 'Hardware Added');
            } else {
                return back()->with('warning', 'Hardware could not be added');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hardware  $hardware
     * @return \Illuminate\Http\Response
     */
    public function show(Hardware $hardware)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hardware  $hardware
     * @return \Illuminate\Http\Response
     */
    public function edit(Hardware $hardware)
    {
        //
        $rooms = Room::whereStatus(1)->whereType(1)->get();
        return view('hardwares.edit', compact('hardware', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hardware  $hardware
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hardware $hardware)
    {
        //
        // return $hardware;
        // return $request;
        try {
            $updated = $hardware->update($request->except('_token'));
            if($updated) {
                return redirect()->route('hardwares.index')->with('success', 'Hardware Updated');
            } else {
                return back()->with('warning', 'Hardware could not be updated');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hardware  $hardware
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hardware $hardware)
    {
        //
        try {
            $deleted = $hardware->delete();
            if($deleted) {
                return back()->with('deleted', 'Hardware Deleted');
            } else {
                return back()->with('warning', 'Hardware could not be deleted');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
