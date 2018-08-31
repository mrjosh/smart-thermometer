<?php

namespace App\Http\Controllers;

class LightsController extends Controller
{
    public function index()
    {
        $lights = app('redis')->get('lights');
        $lights = str_replace("'", '"', $lights);
        $lights = json_decode($lights, true);

        $status = ( $lights['status'] == "On" ? true : false );

        return \Respond::succeed([
            "status" => $status,
            "created_at" => $lights['created_at']
        ]);
    }
}
