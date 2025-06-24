<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class ReportController extends Controller
{
    // 1. Get today's check-in for the authenticated user
    public function today()
    {
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('checked_in_at', $today)
            ->orderByDesc('checked_in_at')
            ->first();

        return response()->json([
            'today_checkin' => $attendance
        ]);
    }

    // 2. Get full attendance history for the user
    public function history()
    {
        $attendances = Attendance::where('user_id', Auth::id())
            ->orderByDesc('checked_in_at')
            ->get();

        return response()->json([
            'history' => $attendances
        ]);
    }

    // 3. Filtered report by date range
    public function filter(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $attendances = Attendance::where('user_id', Auth::id())
            ->whereBetween('checked_in_at', [$request->from, $request->to])
            ->orderBy('checked_in_at', 'desc')
            ->get();

        return response()->json([
            'filtered' => $attendances
        ]);
    }
}
