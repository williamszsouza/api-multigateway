<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function getClients(){
        $clients = Clients::all();

        return response()->json([
            'clients' => $clients
        ]);
    }
}
