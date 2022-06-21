<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\LightScene;
use App\Models\Room;
use Illuminate\Http\Request;

class LightSceneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $scenes = LightScene::with('commands', 'room')->get();
        foreach ($scenes as $scene) {
            $commands = array();
            foreach ($scene->commands as $command) {
                array_push($commands, $command->name);
            }
            $scene->commands_arr = $commands;
        }
        // return $scenes;
        return view('light_scenes.index', compact('scenes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $rooms = Room::whereStatus(1)->whereType(1)->get(['name', 'id']);
        return view('light_scenes.create', compact('rooms'));
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
            $scene = LightScene::create($request->except('_token'));
            if ($scene) {
                $scene->commands()->attach($request->command_ids);
                return redirect()->route('light_scenes.index')->with('success', 'Light Scene Created');
            } else {
                return back()->with('warning', 'Light Scene could not be created');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LightScene  $lightScene
     * @return \Illuminate\Http\Response
     */
    public function show(LightScene $lightScene)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LightScene  $lightScene
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $scene = LightScene::with('commands')->find($id);
        $commands = array();
        foreach ($scene->commands as $command) {
            array_push($commands, $command->id);
        }
        $scene->commands_arr = $commands;
        $rooms = Room::whereStatus(1)->whereType(1)->get(['name', 'id']);
        // $commands = Command::whereRoomId($scene->room_id)->get(['name', 'id']);

        $commands = Command::with('hardware')->whereRoomId($scene->room_id)->get(['name', 'id', 'hardware_id']);
        $commands_grouped = $commands->groupBy('hardware.name');
        // $commands_grouped = array();
        // foreach ($temp_grouped as $key => $value) {
        //     $temp['hardware_name'] = $key;
        //     $temp['commands'] = $value;
        //     array_push($commands_grouped, $temp);
        // }
        return view('light_scenes.edit', compact('scene', 'rooms', 'commands_grouped'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LightScene  $lightScene
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LightScene $lightScene)
    {
        //
        try {
            $updated = $lightScene->update($request->except('_token'));
            if ($updated) {
                $lightScene->commands()->sync($request->command_ids);
                return redirect()->route('light_scenes.index')->with('success', 'Light Scene Updated');
            } else {
                return back()->with('warning', 'Light Scene could not be updated');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LightScene  $lightScene
     * @return \Illuminate\Http\Response
     */
    public function destroy(LightScene $lightScene)
    {
        //
        try {
            $deleted = $lightScene->delete();
            if ($deleted) {
                return back()->with('deleted', 'Light Scene Deleted');
            } else {
                return back()->with('warning', 'Light Scene could not be deleted');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
