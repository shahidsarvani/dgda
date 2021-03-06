<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Lighting;
use App\Models\LightingType;
use App\Models\Room;
use App\Models\Scene;
use Illuminate\Http\Request;

class LightingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $lightings = Lighting::with('command', 'room')->get();
        $rooms = Room::whereStatus(1)->whereType(1)->get(['name', 'id']);
        $scenes = Scene::whereStatus(1)->get(['name', 'id']);
        $commands = Command::get(['name', 'id']);
        $lighting_types = LightingType::whereStatus(1)->get(['name', 'id']);
        return view('lightings.index', compact('lightings', 'rooms', 'scenes', 'commands', 'lighting_types'));
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
            $lighting = Lighting::create($request->except('_token'));
            if($lighting) {
                return back()->with('success', 'Lighting Created');
            } else {
                return back()->with('warning', 'Lighting could not be created');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lighting  $lighting
     * @return \Illuminate\Http\Response
     */
    public function show(Lighting $lighting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lighting  $lighting
     * @return \Illuminate\Http\Response
     */
    public function edit(Lighting $lighting)
    {
        //
        $rooms = Room::whereStatus(1)->whereType(1)->get(['name', 'id']);
        $scenes = Scene::whereStatus(1)->get(['name', 'id']);
        $commands = Command::get(['name', 'id']);
        $lighting_types = LightingType::whereStatus(1)->get(['name', 'id']);
        return view('lightings.edit', compact('lighting', 'rooms', 'scenes', 'commands', 'lighting_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lighting  $lighting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lighting $lighting)
    {
        //
        // return $lighting;
        // return $request;
        try {
            $updated = $lighting->update($request->except('_token'));
            if($updated) {
                return redirect()->route('lightings.index')->with('success', 'Lighting Updated');
            } else {
                return back()->with('warning', 'Lighting could not be updated');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lighting  $lighting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lighting $lighting)
    {
        //
        try {
            $deleted = $lighting->delete();
            if($deleted) {
                return back()->with('deleted', 'Lighting Deleted');
            } else {
                return back()->with('warning', 'Lighting could not be deleted');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
