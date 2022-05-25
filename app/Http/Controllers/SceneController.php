<?php

namespace App\Http\Controllers;

use App\Models\Scene;
use Illuminate\Http\Request;

class SceneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $scenes = Scene::all();
        return view('scenes.index', compact('scenes'));
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
            $scene = Scene::create($request->except('_token'));
            if($scene) {
                return back()->with('success', 'Scene Created');
            } else {
                return back()->with('warning', 'Scene could not be created');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function show(Scene $scene)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function edit(Scene $scene)
    {
        //
        return view('scenes.edit', compact('scene'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scene $scene)
    {
        //
        // return $scene;
        // return $request;
        try {
            $updated = $scene->update($request->except('_token'));
            if($updated) {
                return redirect()->route('scenes.index')->with('success', 'Scene Updated');
            } else {
                return back()->with('warning', 'Scene could not be updated');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scene $scene)
    {
        //
        try {
            $deleted = $scene->delete();
            if($deleted) {
                return back()->with('deleted', 'Scene Deleted');
            } else {
                return back()->with('warning', 'Scene could not be deleted');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
