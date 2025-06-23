<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DeviceLogController extends Controller
{
        public function index()
    {
        $logs = \App\Models\DeviceLog::with('user')->latest()->paginate(20);
        return Inertia::render('DeviceLogs/Index', ['logs' => $logs]);
    }

}
