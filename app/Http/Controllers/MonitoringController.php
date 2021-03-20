<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        return view('monitoring.index');
    }

    public function filter(Request $request)
    {
        echo json_encode($request->all());
    }
}
