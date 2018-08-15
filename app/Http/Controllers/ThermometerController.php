<?php

namespace App\Http\Controllers;

class ThermometerController extends Controller
{
    public function index()
    {
        $temperature = app('redis')->get('temperature');

        $humidity = app('redis')->get('humidity');

        return \Respond::succeed([
            "temperature" => $temperature['value'],
            "humidity" => $humidity['value'],
            "updated_at" => $temperature['created_at']
        ]);
    }
}
