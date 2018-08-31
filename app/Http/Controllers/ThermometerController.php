<?php

namespace App\Http\Controllers;

class ThermometerController extends Controller
{
    public function index()
    {
        $thermometer = app('redis')->get('thermometer');
        $thermometer = str_replace("'", '"', $thermometer);
        $thermometer = json_decode($thermometer, true);

        return \Respond::succeed([
            "temperature" => $thermometer['temperature'],
            "humidity" => $thermometer['humidity'],
            "cooler_status" => (boolean)$thermometer['cooler_status'],
            "created_at" => $thermometer['created_at']
        ]);
    }
}
