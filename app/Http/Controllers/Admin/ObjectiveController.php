<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Objective;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ObjectiveController extends Controller
{
    protected function ensureAdmin(): void
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'admin') {
            abort(403);
        }
    }

    public function index(): Response
    {
        $this->ensureAdmin();

        $objectives = Objective::query()
            ->orderBy('number')
            ->latest('created_at')
            ->get();

        return Inertia::render('Admin/Objectives', [
            'objectives' => $objectives,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'number' => ['required', 'integer', 'min:1', 'max:10'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'file', 'max:10240', 'mimetypes:image/jpeg,image/png,image/webp,image/svg+xml,image/heic'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('objectives', 'public');
            $data['image_url'] = Storage::url($path);
        }

        unset($data['image']);

        $data['is_active'] = $request->has('is_active');

        Objective::create($data);

        return redirect()->back()->with('success', 'Objective created successfully');
    }

    public function update(Request $request, Objective $objective): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'number' => ['required', 'integer', 'min:1', 'max:10'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($objective->image_url && Storage::exists('objectives/' . basename($objective->image_url))) {
                Storage::delete('objectives/' . basename($objective->image_url));
            }
            $path = $request->file('image')->store('objectives', 'public');
            $data['image_url'] = Storage::url($path);
        }

        unset($data['image']);

        $data['is_active'] = $request->has('is_active');

        $objective->update($data);

        return redirect()->back()->with('success', 'Objective updated successfully');
    }

    public function destroy(Objective $objective): RedirectResponse
    {
        $this->ensureAdmin();

        if ($objective->image_url && Storage::exists('objectives/' . basename($objective->image_url))) {
            Storage::delete('objectives/' . basename($objective->image_url));
        }

        $objective->delete();

        return redirect()->back()->with('success', 'Objective deleted successfully');
    }
}
