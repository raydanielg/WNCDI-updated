<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    protected function ensureAdmin(): void
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $notifications = Notification::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return Inertia::render('Admin/Notifications', [
            'notifications' => $notifications,
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:255'],
            'is_published' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_published'] = $data['is_published'] ?? false;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Notification::create($data);

        return redirect()->back();
    }

    public function update(Request $request, Notification $notification)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:255'],
            'is_published' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_published'] = $data['is_published'] ?? false;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $notification->update($data);

        return redirect()->back();
    }

    public function destroy(Notification $notification)
    {
        $this->ensureAdmin();

        $notification->delete();

        return redirect()->back();
    }
}
