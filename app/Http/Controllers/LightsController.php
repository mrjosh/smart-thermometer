<?php

namespace App\Http\Controllers;

class LightsController extends Controller
{
    public function index()
    {
        $lights = app('redis')->get('lights');
        $lights = str_replace("'", '"', $lights);
        $lights = json_decode($lights, true);

        return \Respond::succeed($lights);
    }
}
