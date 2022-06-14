<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Room;
use App\Models\Scene;
use App\Models\Zone;
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
        // return phpversion();
        $scenes = Scene::with('commands', 'room')->get();
        foreach ($scenes as $scene) {
            $commands = array();
            foreach ($scene->commands as $command) {
                array_push($commands, $command->name);
            }
            $scene->commands_arr = $commands;
        }
        // return $scenes;
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
        $rooms = Room::whereStatus(1)->whereType(1)->get(['name', 'id']);
        return view('scenes.create', compact('rooms'));
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
            if ($scene) {
                $scene->commands()->attach($request->command_ids);
                return redirect()->route('scenes.index')->with('success', 'Scene Created');
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
    public function edit($id)
    {
        //
        $scene = Scene::with('commands')->find($id);
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
        return view('scenes.edit', compact('scene', 'rooms', 'commands_grouped'));
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
            if ($updated) {
                $scene->commands()->sync($request->command_ids);
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
        // return $scene;
        try {
            $deleted = $scene->delete();
            if ($deleted) {
                return back()->with('deleted', 'Scene Deleted');
            } else {
                return back()->with('warning', 'Scene could not be deleted');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function scenes_play($id)
    {
        $sock = socket_create_listen(0);
        $addr = '192.168.10.10';
        $port = 58900;
        socket_getsockname($sock, $addr, $port);
        print "Server Listening on $addr:$port\n";
        // $fp = fopen($port_file, 'w');
        // fwrite($fp, $port);
        // fclose($fp);
        // while ($c = socket_accept($sock)) {
        //     /* do something useful */
        //     socket_getpeername($c, $raddr, $rport);
        //     print "Received Connection from $raddr:$rport\n";
        // }
        socket_close($sock);
    }

    // public function scenes_play($id)
    // {
    //     $scene = Scene::find($id);
    //     // return $scene;
    //     $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    //     if ($socket === false) {
    //         return response()->json([
    //             'status' => 0,
    //             'title' => 'Error',
    //             'msg' => 'Socket is not created!'
    //         ]);
    //     }
    //     $msg = 'Hello World';
    //     $len = strlen($msg);

    //     // $msg_error = 'Conexion no establecida';

    //     // $connection = socket_connect($socket, '192.168.10.10', 58900);

    //     // socket_bind($socket, '192.168.10.10', 58900);
    //     socket_listen($socket, 1);
    //     socket_set_nonblock($socket);
    //     while (true) {
    //         if (($newc = socket_accept($socket)) !== false) {
    //             echo "Client $newc has connected\n";
    //             $clients[] = $newc;
    //         }
    //     }
    //     // sleep(20);

    //     // if ($connection == false) {
    //     //     return response()->json([
    //     //         'status' => 0,
    //     //         'title' => 'Error',
    //     //         'msg' => 'Socket connection failed!'
    //     //     ]);
    //     // }

    //     // $resultado = socket_sendto($socket, $msg, $len, 0, '192.168.10.10', 58900);

    //     // if ($resultado) {
    //     //     socket_close($socket);
    //     //     return response()->json([
    //     //         'status' => 1,
    //     //         'title' => 'Success',
    //     //         'msg' => 'Message sent!'
    //     //     ]);
    //     // }

    //     // return $msg;
    // }
}
