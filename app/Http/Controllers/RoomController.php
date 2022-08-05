<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Hardware;
use App\Models\Phase;
use App\Models\Room;
use App\Models\Scene;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rooms = Room::all();
        $scenes = Scene::all();
        $setting = Setting::find(1);
        return view('rooms.index', compact('rooms', 'setting', 'scenes'));
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
            $data = $request->except('_token', 'image', 'image_ar', 'icon', 'icon_ar');
            $room = new Room();
            if ($file = $request->file('image')) {
                $imagePath = $room->getImagePath();
                $name = 'room_english_' . md5(time());
                $file->storeAs($imagePath, $name);
                $data['image'] = $name;
            }
            if ($file = $request->file('image_ar')) {
                $imagePath = $room->getImagePath();
                $name = 'room_arabic_' . md5(time());
                $file->storeAs($imagePath, $name);
                $data['image_ar'] = $name;
            }
            if ($file = $request->file('icon')) {
                $imagePath = $room->getImagePath();
                $name = 'room_english_' . md5(time());
                $file->storeAs($imagePath, $name);
                $data['icon'] = $name;
            }
            if ($file = $request->file('icon_ar')) {
                $imagePath = $room->getImagePath();
                $name = 'room_arabic_' . md5(time());
                $file->storeAs($imagePath, $name);
                $data['icon_ar'] = $name;
            }
            $room = Room::create($data);
            if ($room) {
                return back()->with('success', 'Room Created');
            } else {
                return back()->with('warning', 'Room could not be created');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
        $scenes = Scene::all();
        return view('rooms.edit', compact('room', 'scenes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
        // return $room;
        // return $request;
        try {
            $data = $request->except('_token', 'image', 'image_ar', 'icon', 'icon_ar');
            if ($file = $request->file('image')) {
                $imagePath = $room->getImagePath();
                $name = 'room_english_' . md5(time());
                $file->storeAs($imagePath, $name);
                $data['image'] = $name;
            }
            if ($file = $request->file('image_ar')) {
                $imagePath = $room->getImagePath();
                $name = 'room_arabic_' . md5(time());
                $file->storeAs($imagePath, $name);
                $data['image_ar'] = $name;
            }
            if ($file = $request->file('icon')) {
                $imagePath = $room->getImagePath();
                $name = 'room_english_' . md5(time());
                $file->storeAs($imagePath, $name);
                $data['icon'] = $name;
            }
            if ($file = $request->file('icon_ar')) {
                $imagePath = $room->getImagePath();
                $name = 'room_arabic_' . md5(time());
                $file->storeAs($imagePath, $name);
                $data['icon_ar'] = $name;
            }
            $updated = $room->update($data);
            if ($updated) {
                return redirect()->route('rooms.index')->with('success', 'Room Updated');
            } else {
                return back()->with('warning', 'Room could not be updated');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
        try {
            $deleted = $room->delete();
            if ($deleted) {
                return back()->with('deleted', 'Room Deleted');
            } else {
                return back()->with('warning', 'Room could not be deleted');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function get_room_hardware(Request $request)
    {
        $hardwares = Hardware::whereRoomId($request->room_id)->get(['name', 'id']);
        return response()->json($hardwares);
        // $hardwares;
    }

    public function get_room_command(Request $request)
    {
        $commands = Command::with('hardware')->whereRoomId($request->room_id)->get(['name', 'id', 'hardware_id']);
        $temp_grouped = $commands->groupBy('hardware.name');
        $commands_grouped = array();
        foreach ($temp_grouped as $key => $value) {
            $temp['hardware_name'] = $key;
            $temp['commands'] = $value;
            array_push($commands_grouped, $temp);
        }
        return response()->json($commands_grouped);
        // $hardwares;
    }

    public function get_room_crestron_command(Request $request)
    {
        $commands = Command::with('hardware')->whereRoomId($request->room_id)->get(['name', 'id', 'hardware_id']);
        // return $commands;
        $temp_grouped = $commands->groupBy('hardware.name');
        $commands_grouped = array();
        foreach ($temp_grouped as $key => $value) {
            $temp['hardware_name'] = $key;
            $temp['commands'] = $value;
            array_push($commands_grouped, $temp);
        }
        return response()->json($commands_grouped);
        // $hardwares;
    }

    public function get_room_scenes_and_phases(Request $request)
    {
        $data['scenes'] = Scene::whereRoomId($request->room_id)->get(['name', 'id']);
        $data['phases'] = Phase::whereRoomId($request->room_id)->get(['name', 'id']);
        return response()->json($data);
        // $hardwares;
    }
}
