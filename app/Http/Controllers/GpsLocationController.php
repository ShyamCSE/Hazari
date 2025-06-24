<?php

namespace App\Http\Controllers;

use App\Models\gpsLocation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GpsLocationController extends Controller
{
   // app/Http/Controllers/Admin/GpsLocationController.php
public function index()
{
    $locations = gpsLocation::where('admin_id', auth()->id())->paginate(10);

    return Inertia::render('GpsLocation/Index', [
        'locations' => $locations,
    ]);
}

public function create()
{
    return Inertia::render('GpsLocation/Create');
}

public function store(Request $request)
{
    $data = $request->validate([
        'location_name' => 'required|string|max:255',
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
        'radius' => 'required|integer|min:10|max:1000',
    ]);

    $data['admin_id'] = auth()->id();

    GpsLocation::create($data);

    return redirect()->route('gps-attendance.index')->with('success', 'GPS Location added successfully.');
}



}
