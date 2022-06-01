<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use App\Models\Room;
use App\Models\Zone;
use Illuminate\Http\Request;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $phases = Phase::with('room')->get();
        $rooms = Room::whereStatus(1)->whereType(1)->get(['name', 'id']);
        return view('phases.index', compact('phases', 'rooms'));
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
            $phase = Phase::create($request->except('_token'));
            if($phase) {
                return back()->with('success', 'Phase Created');
            } else {
                return back()->with('warning', 'Phase could not be created');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function show(Phase $phase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function edit(Phase $phase)
    {
        //
        $rooms = Room::whereStatus(1)->whereType(1)->get(['name', 'id']);
        return view('phases.edit', compact('phase', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Phase $phase)
    {
        //
        // return $phase;
        // return $request;
        try {
            $updated = $phase->update($request->except('_token'));
            if($updated) {
                return redirect()->route('phases.index')->with('success', 'Phase Updated');
            } else {
                return back()->with('warning', 'Phase could not be updated');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phase $phase)
    {
        //
        // return $phase;
        try {
            $deleted = $phase->delete();
            if($deleted) {
                return back()->with('deleted', 'Phase Deleted');
            } else {
                return back()->with('warning', 'Phase could not be deleted');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function get_phase_zones(Request $request)
    {
        $zones = Zone::wherePhaseId($request->phase_id)->get(['name', 'id']);
        return response()->json($zones);
        // $hardwares;
    }
}
