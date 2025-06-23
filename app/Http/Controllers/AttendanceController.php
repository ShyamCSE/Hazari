<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendanceController extends Controller
{
        public function index()
    {
        $attendances = Attendance::with('user')->latest()->paginate(10);

        return Inertia::render('Attendance/Index', [
            'attendances' => $attendances,
        ]);
    }


    public function logs() {
        return Inertia::render('Attendance/Logs');
    }

}
