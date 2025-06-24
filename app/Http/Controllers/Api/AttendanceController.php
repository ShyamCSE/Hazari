<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function gpsCheckIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'location_id' => 'required|exists:locations,id'
        ]);

        Attendance::create([
            'user_id' => Auth::id(),
            'method' => 'gps',
            'location_id' => $request->location_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'checked_in_at' => now()
        ]);

        return response()->json(['message' => 'GPS check-in successful']);
    }

    public function wifiCheckIn(Request $request)
    {
        $request->validate([
            'bssid' => 'required|string',
            'location_id' => 'required|exists:locations,id'
        ]);

        Attendance::create([
            'user_id' => Auth::id(),
            'method' => 'wifi',
            'location_id' => $request->location_id,
            'wifi_bssid' => $request->bssid,
            'checked_in_at' => now()
        ]);

        return response()->json(['message' => 'Wi-Fi check-in successful']);
    }

    public function manualCheckIn(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
            'location_id' => 'required|exists:locations,id'
        ]);

        $path = $request->file('photo')->store('checkin_photos', 'public');

        Attendance::create([
            'user_id' => Auth::id(),
            'method' => 'manual',
            'location_id' => $request->location_id,
            'photo_path' => $path,
            'checked_in_at' => now()
        ]);

        return response()->json(['message' => 'Manual check-in successful']);
    }
}
