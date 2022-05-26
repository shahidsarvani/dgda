<?php

namespace App\Http\Controllers;

use App\Models\Lighting;
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
        $scenes = Scene::with('command', 'room')->get();
        $rooms = Room::whereStatus(1)->whereType(1)->get(['name', 'id']);
        return view('scenes.index', compact('scenes', 'rooms'));
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
    }
}
