<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class HeroController extends Controller
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

        $slides = HeroSlide::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'title', 'badge', 'description', 'image_url', 'sort_order', 'is_active', 'created_at']);

        return Inertia::render('Admin/Hero', [
            'slides' => $slides,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'file', 'max:15360', 'mimetypes:image/jpeg,image/png,image/webp,image/svg+xml,image/heic'],
            'sort_order' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hero', 'public');
            $data['image_url'] = Storage::url($path);
        }

        if (! isset($data['sort_order'])) {
            $maxOrder = HeroSlide::max('sort_order');
            $data['sort_order'] = $maxOrder ? $maxOrder + 1 : 1;
        }

        $data['is_active'] = $data['is_active'] ?? true;
        unset($data['image']);

        HeroSlide::create($data);

        return redirect()->back();
    }

    public function update(Request $request, HeroSlide $slide): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'file', 'max:15360', 'mimetypes:image/jpeg,image/png,image/webp,image/svg+xml,image/heic'],
            'sort_order' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hero', 'public');
            $data['image_url'] = Storage::url($path);
        }

        if (! isset($data['sort_order'])) {
            $data['sort_order'] = $slide->sort_order ?? 1;
        }

        $data['is_active'] = $data['is_active'] ?? false;
        unset($data['image']);

        $slide->update($data);

        return redirect()->back();
    }

    public function destroy(HeroSlide $slide): RedirectResponse
    {
        $this->ensureAdmin();

        $slide->delete();

        return redirect()->back();
    }
}
