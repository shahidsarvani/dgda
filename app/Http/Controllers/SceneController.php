<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Media;
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
        $media_en = Media::whereSceneId(null)->whereLang('en')->get(['name', 'id']);
        $media_ar = Media::whereSceneId(null)->whereLang('ar')->get(['name', 'id']);
        return view('scenes.create', compact('rooms', 'media_en', 'media_ar'));
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
        // return $filtered;
        try {
            $scene = Scene::create($request->except('_token'));
            if ($scene) {
                // $scene->commands()->attach($request->command_ids);
                $scene->commands()->attach($data);
                if ($request->media_ar_id) {
                    $media = Media::find($request->media_ar_id);
                    $media->update(['scene_id' => $scene->id]);
                }
                if ($request->media_en_id) {
                    $media = Media::find($request->media_en_id);
                    $media->update(['scene_id' => $scene->id]);
                }
                return redirect()->route('scenes.index')->with('success', 'Scene Created');
            } else {
                return back()->with('warning', 'Scene could not be created');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }

        function remove_null($value)
        {
            return !is_null($value);
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
        $scene = Scene::with('commands', 'media')->find($id);
        // return $scene->commands;
        $commands = array();
        $sort_order = array();
        foreach ($scene->commands as $command) {
            array_push($commands, $command->id);
            array_push($sort_order, $command->pivot->sort_order);
        }
        // return $sort_order;
        // return $commands;
        $scene->commands_arr = $commands;
        $sort_arr = $sort_order;
        $rooms = Room::whereStatus(1)->whereType(1)->get(['name', 'id']);
        // $commands = Command::whereRoomId($scene->room_id)->get(['name', 'id']);

        $commands = Command::with('hardware')->whereRoomId($scene->room_id)->get(['name', 'id', 'hardware_id']);
        $commands_grouped = $commands->groupBy('hardware.name');
        $media = Media::whereSceneId(null)->orWhere('scene_id', $scene->id)->get(['name', 'id']);
        // return $commands;
        // $commands_grouped = array();
        // foreach ($temp_grouped as $key => $value) {
        //     $temp['hardware_name'] = $key;
        //     $temp['commands'] = $value;
        //     array_push($commands_grouped, $temp);
        // }
        return view('scenes.edit', compact('scene', 'rooms', 'commands_grouped', 'media', 'sort_arr'));
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
        $input = $request->except('_token');
        if(!$request->is_default) {
            $input['is_default'] = 0;
        }
        // return $input;
        try {
            $updated = $scene->update($input);
            if ($updated) {
                // $scene->commands()->sync($request->command_ids);
                $scene->commands()->sync($data);
                if ($request->media_id) {
                    $media = Media::find($request->media_id);
                    $media->update(['scene_id' => $scene->id]);
                }
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
        // set some variables
        $host = "0.0.0.0";
        $port = 58900;
        // don't timeout!
        set_time_limit(0);
        // create socket
        $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
        // bind socket to port
        $result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
        // // start listening for connections
        $result = socket_listen($socket, 3) or die("Could not set up socket listener\n");

        // return $result;
        // accept incoming connections
        // spawn another socket to handle communication
        $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
        // read client input
        $input = socket_read($spawn, 1024) or die("Could not read input\n");
        // clean up input string
        $input = trim($input);
        echo "Client Message : " . $input;
        // reverse client input and send back
        $output = strrev($input) . "\n";
        socket_write($spawn, $output, strlen($output)) or die("Could not write output\n");
        // close sockets
        socket_close($spawn);
        socket_close($socket);
    }

    // public function scenes_play($id)
    // {
    //     $msg = 'Hello';
    //     $len = strlen($msg);
    //     $port = 58900;
    //     $sock = socket_create_listen($port);
    //     $addr = '192.168.10.10';
    //     $name = socket_getsockname($sock, $addr, $port);
    //     // return $name;
    //     // socket_bind($sock, $addr, $port);
    //     print "Server Listening on $addr:$port\n";
    //     // $fp = fopen($port_file, 'w');
    //     // fwrite($fp, $port);
    //     // fclose($fp);
    //     // while ($c = socket_accept($sock)) {
    //     //     /* do something useful */
    //     //     socket_getpeername($c, $raddr, $rport);
    //     //     print "Received Connection from $raddr:$rport\n";
    //     // }
    //     // socket_close($sock);
    //     $resultado = socket_sendto($sock, $msg, $len, 0, $addr, $port);

    //     if ($resultado) {
    //         socket_close($sock);
    //         return response()->json([
    //             'status' => 1,
    //             'title' => 'Success',
    //             'msg' => 'Message sent!'
    //         ]);
    //     }
    // }

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

    // $resultado = socket_sendto($socket, $msg, $len, 0, '192.168.10.10', 58900);

    // if ($resultado) {
    //     socket_close($socket);
    //     return response()->json([
    //         'status' => 1,
    //         'title' => 'Success',
    //         'msg' => 'Message sent!'
    //     ]);
    // }

    //     // return $msg;
    // }
}
