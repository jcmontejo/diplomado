<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class SmsController extends Controller
{
    public function send()
    {
        // Nexmo::message()->send([
        //     'to' => '529612685249',
        //     'from' => 'Avanza Solido',
        //     'text' => 'Hola desde Avanza Solido',
        // ]);
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', 'https://api.github.com/user', [
            'auth' => ['user', 'pass'],
        ]);
    }
}
