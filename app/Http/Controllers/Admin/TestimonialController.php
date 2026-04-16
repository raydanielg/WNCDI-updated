<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class TestimonialController extends Controller
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

        $testimonials = Testimonial::query()
            ->orderByDesc('created_at')
            ->get([
                'id',
                'name',
                'role',
                'avatar_url',
                'headline',
                'body1',
                'body2',
                'created_at',
            ]);

        return Inertia::render('Admin/Testimonials', [
            'testimonials' => $testimonials,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'avatar_url' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'headline' => ['nullable', 'string', 'max:255'],
            'body1' => ['nullable', 'string'],
            'body2' => ['nullable', 'string'],
        ]);

        // Handle avatar upload (if provided)
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('testimonials', 'public');
            $data['avatar_url'] = Storage::url($path);
        }

        unset($data['avatar']);

        Testimonial::create($data);

        return redirect()->back();
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'avatar_url' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'headline' => ['nullable', 'string', 'max:255'],
            'body1' => ['nullable', 'string'],
            'body2' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('testimonials', 'public');
            $data['avatar_url'] = Storage::url($path);
        }

        unset($data['avatar']);

        $testimonial->update($data);

        return redirect()->back();
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $this->ensureAdmin();

        $testimonial->delete();

        return redirect()->back();
    }
}
