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

    return Inertia::render('admin/GpsLocation/Index', [
        'locations' => $locations,
    ]);
}

public function create()
{
    return Inertia::render('admin/GpsLocation/Create');
}

public function store(Request $request)
{
    $data = $request->validate([
        'location_name' => 'required|string|max:255',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'radius' => 'required|integer|min:10|max:1000',
    ]);

    GpsLocation::create([...$data, 'admin_id' => auth()->id()]);

    return redirect()->route('admin.gps.index');
}

}
