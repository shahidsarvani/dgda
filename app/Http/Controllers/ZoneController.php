<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use App\Models\Room;
use App\Models\Scene;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $zones = Zone::with('phase', 'room')->get();
        $rooms = Room::whereStatus(1)->get(['name', 'id']);
        return view('zones.index', compact('zones', 'rooms'));
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
        //
        // return $request;
        try {
            $zone = Zone::create($request->except('_token'));
            if($zone) {
                return back()->with('success', 'Zone Created');
            } else {
                return back()->with('warning', 'Zone could not be created');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone)
    {
        //
        $phases = Phase::whereStatus(1)->get(['name', 'id']);
        $scenes = Scene::whereStatus(1)->get(['name', 'id']);
        $rooms = Room::whereStatus(1)->get(['name', 'id']);
        return view('zones.edit', compact('zone', 'phases', 'scenes', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone)
    {
        //
        // return $zone;
        // return $request;
        try {
            $updated = $zone->update($request->except('_token'));
            if($updated) {
                return redirect()->route('zones.index')->with('success', 'Zone Updated');
            } else {
                return back()->with('warning', 'Zone could not be updated');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone)
    {
        //
        // return $zone;
        try {
            $deleted = $zone->delete();
            if($deleted) {
                return back()->with('deleted', 'Zone Deleted');
            } else {
                return back()->with('warning', 'Zone could not be deleted');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
