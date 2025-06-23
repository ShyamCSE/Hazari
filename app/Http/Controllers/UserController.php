<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{

        public function dashboard()
    {
        $attendances = Attendance::with('user')->latest()->take(5)->get();

        return Inertia::render('Dashboard', [
            'recentAttendances' => $attendances,
        ]);
    }

    public function index(Request $request)
    {
        $query = User::latest();

        // Filters
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status === '1');
        }

        if ($request->filled('type')) {
            $query->where('type', (int) $request->type); // Ensure proper casting
        }

      return Inertia::render('Users/Index', [
        'filters' => $request->only(['search', 'status', 'type']),
        'users' => $query->latest()->paginate(10)->withQueryString(),
    ]);

    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $validated['status'] = 1;
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 1 ? 0 : 1;
        $user->save();

        return back()->with('success', 'User status updated.');
    }
}
