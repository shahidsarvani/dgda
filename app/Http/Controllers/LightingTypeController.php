<?php

namespace App\Http\Controllers;

use App\Models\LightingType;
use Illuminate\Http\Request;

class LightingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $lighting_types = LightingType::all();
        return view('lighting_types.index', compact('lighting_types'));
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
            $lighting_type = LightingType::create($request->except('_token'));
            if($lighting_type) {
                return back()->with('success', 'Lighting Type Created');
            } else {
                return back()->with('warning', 'Lighting Type could not be created');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LightingType  $lightingType
     * @return \Illuminate\Http\Response
     */
    public function show(LightingType $lightingType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LightingType  $lightingType
     * @return \Illuminate\Http\Response
     */
    public function edit(LightingType $lightingType)
    {
        //
        return view('lighting_types.edit', compact('lightingType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LightingType  $lightingType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LightingType $lightingType)
    {
        //
        // return $lightingType;
        // return $request;
        try {
            $updated = $lightingType->update($request->except('_token'));
            if($updated) {
                return redirect()->route('lighting_types.index')->with('success', 'Lighting Type Updated');
            } else {
                return back()->with('warning', 'Lighting Type could not be updated');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LightingType  $lightingType
     * @return \Illuminate\Http\Response
     */
    public function destroy(LightingType $lightingType)
    {
        //
        try {
            $deleted = $lightingType->delete();
            if($deleted) {
                return back()->with('deleted', 'Lighting Type Deleted');
            } else {
                return back()->with('warning', 'Lighting Type could not be deleted');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
