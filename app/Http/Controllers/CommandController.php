<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Hardware;
use App\Models\Room;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $commands = Command::with('room', 'hardware')->get();
        $rooms = Room::whereStatus(1)->whereType(1)->get(['name', 'id']);
        // return $rooms;
        return view('commands.index', compact('commands', 'rooms'));
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
            $command = Command::create($request->except('_token'));
            if ($command) {
                return back()->with('success', 'Command Created');
            } else {
                return back()->with('warning', 'Command could not be created');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function show(Command $command)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function edit(Command $command)
    {
        //
        $rooms = Room::whereStatus(1)->whereType(1)->get(['name', 'id']);
        $hardwares = Hardware::whereRoomId($command->room_id)->get(['name', 'id']);
        return view('commands.edit', compact('command', 'rooms', 'hardwares'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Command $command)
    {
        //
        // return $command;
        // return $request;
        try {
            $updated = $command->update($request->except('_token'));
            if ($updated) {
                return redirect()->route('commands.index')->with('success', 'Command Updated');
            } else {
                return back()->with('warning', 'Command could not be updated');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function destroy(Command $command)
    {
        //
        try {
            $deleted = $command->delete();
            if ($deleted) {
                return back()->with('deleted', 'Command Deleted');
            } else {
                return back()->with('warning', 'Command could not be deleted');
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
}
