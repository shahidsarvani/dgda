<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SocketServer;

class UserController extends Controller
{
    //

    public function dashboard()
    {
        return view('dashboard-new');
    }

    public function test()
    {
        return view('test');
    }

    public function do_test(Request $request)
    {
        // return $request;
        $port = $request->get('port');
        // return $port;
        $server = new SocketServer("", $port); // Create a Server binding to the given ip address and listen to port 58900 for connections
        //$client = new SocketServerClient($server, 1);
        $server->max_clients = 10; // Allow no more than 10 people to connect at a time
        $res = $server->hook("CONNECT", "handle_connect"); // Run handle_connect every time someone connects
        return $res;
        $server->hook("INPUT", "handle_input"); // Run handle_input whenever text is sent to the server
        $server->loop_once();
    }

    function handle_connect(&$server, &$client, $input)
    {
        SocketServer::socket_write_smart($client->socket, "String? ", "");
        SocketServer::debug("Client Connected");
    }
    function handle_input(&$server, &$client, $input)
    {
        // You probably want to sanitize your inputs here
        $trim = trim($input); // Trim the input, Remove Line Endings and Extra Whitespace.

        if (strtolower($trim) == "quit") // User Wants to quit the server
        {
            SocketServer::socket_write_smart($client->socket, "Oh... Goodbye..."); // Give the user a sad goodbye message, meany!
            $server->disconnect($client->server_clients_index); // Disconnect this client.
            return; // Ends the function
        }

        $output = strrev($trim); // Reverse the String

        SocketServer::socket_write_smart($client->socket, $output); // Send the Client back the String
        SocketServer::socket_write_smart($client->socket, "String? ", ""); // Request Another String
    }
}
