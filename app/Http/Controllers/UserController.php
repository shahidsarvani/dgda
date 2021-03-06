<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SocketServer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //

    public function dashboard()
    {
        // return view('dashboard-new');
        return redirect()->route('rooms.index');
    }

    public function test()
    {
        return view('test');
    }

    public function do_test(Request $request)
    {
        // return $request;
        try {
            //code...
            $port = $request->get('port');
            // return $port;
            $server = new SocketServer("", $port); // Create a Server binding to the given ip address and listen to port 58900 for connections
            // return json_encode($server);
            //$client = new SocketServerClient($server, 1);
            $server->max_clients = 10; // Allow no more than 10 people to connect at a time
            $res = $server->hook("CONNECT", route('handle_connect')); // Run handle_connect every time someone connects
            // $server->hook("INPUT", "handle_input"); // Run handle_input whenever text is sent to the server
            $server->loop_once();
            // $server->infinite_loop();
            // return json_encode($res);
            Log::info(json_encode($server->clients));
            return response()->json([
                'status' => true,
            ]);


            // function handle_input(&$server, &$client, $input)
            // {
            //     // You probably want to sanitize your inputs here
            //     $trim = trim($input); // Trim the input, Remove Line Endings and Extra Whitespace.

            //     if (strtolower($trim) == "quit") // User Wants to quit the server
            //     {
            //         SocketServer::socket_write_smart($client->socket, "Oh... Goodbye..."); // Give the user a sad goodbye message, meany!
            //         $server->disconnect($client->server_clients_index); // Disconnect this client.
            //         return; // Ends the function
            //     }

            //     $output = strrev($trim); // Reverse the String

            //     SocketServer::socket_write_smart($client->socket, $output); // Send the Client back the String
            //     SocketServer::socket_write_smart($client->socket, "String? ", ""); // Request Another String
            // }
        } catch (\Exception $th) {
            //throw $th;
            Log::error('Error: ' . $th->getMessage());
            return response()->json([
                'status' => false,
            ]);
        }
    }

    // public function do_send_command(Request $request)
    // {
    //     try {
    //         $command = $request->command;
    //         $server->hook("INPUT", "handle_input"); // Run handle_input whenever text is sent to the server
    //         $server->loop_once();
    //     } catch (\Exception $th) {
    //         //throw $th;
    //         Log::error('Error: ' . $th->getMessage());
    //         return response()->json([
    //             'status' => false,
    //         ]);
    //     }
    // }
    
    // function handle_connect(&$server, &$client, $input)
    // {
    //     SocketServer::socket_write_smart($client->socket, "String? ", "");
    //     Log::info("Client Connected");
    // }
}
