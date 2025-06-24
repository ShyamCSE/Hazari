<?php

namespace App\Http\Controllers;

use App\Models\wifiLocation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WifiLocationController extends Controller
{
   public function index()
{
    $locations = wifiLocation::where('admin_id', auth()->id())->paginate(10);

    return Inertia::render('WifiLocation/Index', [
        'locations' => $locations,
    ]);
}

public function create()
{
    return Inertia::render('WifiLocation/Create');
}

public function store(Request $request)
{
    $data = $request->validate([
        'ssid' => 'required|string|max:255',
        'location_name' => 'required|string|max:255',
        'mac_address' => 'nullable|string|max:255',
    ]);

    WifiLocation::create([...$data, 'admin_id' => auth()->id()]);

    return redirect()->route('WifiLocation.index');
}
}
