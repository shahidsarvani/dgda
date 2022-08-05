<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\LightScene;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $sort = $request->sort_order;
        $ids = $request->command_ids;
        $filtered = array();
        $data = array();
        for ($i = 0; $i < count($sort); $i++) {
            if ($sort[$i]) {
                array_push($filtered, $sort[$i]);
            }
        }
        for ($i = 0; $i < count($filtered); $i++) {
            array_push($data, ['command_id' => $ids[$i], 'sort_order' => $filtered[$i]]);
        }
        $datas = $request->except('_token', 'image_en', 'image_ar');
        $scene = new LightScene();
        if ($file = $request->file('image_en')) {
            $imagePath = $scene->getImagePath();
            $name = 'scene_english_' . md5(time());
            $file->storeAs($imagePath, $name);
            $datas['image_en'] = $name;
        }
        // return $datas;
        if ($file = $request->file('image_ar')) {
            $imagePath = $scene->getImagePath();
            $name = 'scene_arabic_' . md5(time());
            $file->storeAs($imagePath, $name);
            $datas['image_ar'] = $name;
        }
        // return $data;
        try {
            $scene = LightScene::create($datas);
            if ($scene) {
                $scene->commands()->attach($data);
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
        $sort_order = array();
        foreach ($scene->commands as $command) {
            array_push($commands, $command->id);
            array_push($sort_order, $command->pivot->sort_order);
        }
        $scene->commands_arr = $commands;
        $sort_arr = $sort_order;
        $rooms = Room::whereStatus(1)->whereType(1)->get(['name', 'id']);
        // $commands = Command::whereRoomId($scene->room_id)->get(['name', 'id']);

        $commands = Command::with('hardware')->whereRoomId($scene->room_id)->get(['name', 'id', 'hardware_id']);
        $commands_grouped = $commands->groupBy('hardware.name');
        return view('light_scenes.edit', compact('scene', 'rooms', 'commands_grouped', 'sort_arr'));
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
        $sort = $request->sort_order;
        $ids = $request->command_ids;
        $filtered = array();
        $data = array();
        for ($i = 0; $i < count($sort); $i++) {
            if ($sort[$i]) {
                array_push($filtered, $sort[$i]);
            }
        }
        for ($i = 0; $i < count($filtered); $i++) {
            array_push($data, ['command_id' => $ids[$i], 'sort_order' => $filtered[$i]]);
        }
        // return $data;
        $datas = $request->except('_token', 'image_en', 'image_ar');
        if ($file = $request->file('image')) {
            $imagePath = $lightScene->getImagePath();
            if ($lightScene->image) {
                // return 'World';
                Storage::delete(['/' . $imagePath . '/' . $lightScene->image]);
            }
            $name = 'scene_english_' . md5(time());
            $file->storeAs($imagePath, $name);
            $datas['image_en'] = $name;
        }
        if ($file = $request->file('image_ar')) {
            $imagePath = $lightScene->getImagePath();
            if ($lightScene->image) {
                // return 'World';
                Storage::delete(['/' . $imagePath . '/' . $lightScene->image_ar]);
            }
            $name = 'scene_arabic_' . md5(time());
            $file->storeAs($imagePath, $name);
            $datas['image_ar'] = $name;
        }
        try {
            $updated = $lightScene->update($datas);
            if ($updated) {
                $lightScene->commands()->sync($data);
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
