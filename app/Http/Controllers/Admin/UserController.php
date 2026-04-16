<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    protected function ensureAdmin(): void
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'admin') {
            abort(403);
        }
    }

    public function index(Request $request): Response
    {
        $this->ensureAdmin();

        $users = User::query()
            ->orderByDesc('created_at')
            ->select('id', 'name', 'email', 'role', 'created_at')
            ->get();

        return Inertia::render('Admin/Users', [
            'users' => $users,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', 'in:user,admin,editor,moderator'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->back()->with('status', 'User created successfully.');
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'role' => 'required|string|in:user,admin,editor,moderator,banned',
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->back()->with('status', 'User role updated.');
    }

    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $this->ensureAdmin();

        $user->update([
            'password' => Hash::make('12345678'),
        ]);

        return redirect()->back()->with('status', 'Password reset to 12345678.');
    }

    public function ban(Request $request, User $user): RedirectResponse
    {
        $this->ensureAdmin();

        $user->update(['role' => 'banned']);

        return redirect()->back()->with('status', 'User has been banned.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->ensureAdmin();

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('status', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->back()->with('status', 'User deleted.');
    }
}
