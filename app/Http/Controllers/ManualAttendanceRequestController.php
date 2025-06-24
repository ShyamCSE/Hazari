<?php

namespace App\Http\Controllers;

use App\Models\ManualAttendanceRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ManualAttendanceRequestController extends Controller
{
    // app/Http/Controllers/Admin/ManualAttendanceController.php

public function index()
{
    $requests = ManualAttendanceRequest::with('user')
        ->where('status', 'pending')
        ->latest()
        ->paginate(10);

    return Inertia::render('ManualAttendance/Index', [
        'requests' => $requests
    ]);
}

public function update(Request $request, ManualAttendanceRequest $manualAttendanceRequest)
{
    $validated = $request->validate([
        'status' => 'required|in:approved,rejected',
    ]);

    $manualAttendanceRequest->update([
        'status' => $validated['status'],
        'reviewed_by' => auth()->id(),
        'reviewed_at' => now(),
    ]);

    return back();
}

}
