<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProgramController extends Controller
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

        $programs = Program::query()
            ->orderBy('sort_order')
            ->latest('created_at')
            ->get();

        return Inertia::render('Admin/Programs', [
            'programs' => $programs,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string'],
            'icon_url' => ['nullable', 'string'],
            'image' => ['nullable', 'file', 'max:10240', 'mimetypes:image/jpeg,image/png,image/webp,image/svg+xml,image/heic'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('programs', 'public');
            $data['image_url'] = Storage::url($path);
        }

        unset($data['image']);

        $data['is_active'] = $request->has('is_active');

        Program::create($data);

        return redirect()->back()->with('success', 'Program created successfully');
    }

    public function update(Request $request, Program $program): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string'],
            'icon_url' => ['nullable', 'string'],
            'image' => ['nullable', 'file', 'max:10240', 'mimetypes:image/jpeg,image/png,image/webp,image/svg+xml,image/heic'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($program->image_url && Storage::exists('programs/' . basename($program->image_url))) {
                Storage::delete('programs/' . basename($program->image_url));
            }
            $path = $request->file('image')->store('programs', 'public');
            $data['image_url'] = Storage::url($path);
        }

        unset($data['image']);

        $data['is_active'] = $request->has('is_active');

        $program->update($data);

        return redirect()->back()->with('success', 'Program updated successfully');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $this->ensureAdmin();

        if ($program->image_url && Storage::exists('programs/' . basename($program->image_url))) {
            Storage::delete('programs/' . basename($program->image_url));
        }

        $program->delete();

        return redirect()->back()->with('success', 'Program deleted successfully');
    }
}
