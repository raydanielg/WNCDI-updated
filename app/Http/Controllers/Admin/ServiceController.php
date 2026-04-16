<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
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

        $services = Service::query()
            ->latest('created_at')
            ->get(['id', 'title', 'slug', 'short_description', 'body', 'image_url', 'created_at']);

        return Inertia::render('Admin/Services', [
            'services' => $services,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $data['image_url'] = Storage::url($path);
        }

        unset($data['image']);

        // Ensure unique slug based on title
        $baseSlug = \Str::slug($data['title']);
        $slug = $baseSlug;
        $counter = 2;

        while (Service::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        $data['slug'] = $slug;

        Service::create($data);

        return redirect()->back();
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->ensureAdmin();

        $service = Service::findOrFail($id);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $data['image_url'] = Storage::url($path);
        }

        unset($data['image']);

        // If title changed, keep slug unique as well
        if (isset($data['title']) && $data['title'] !== $service->title) {
            $baseSlug = \Str::slug($data['title']);
            $slug = $baseSlug;
            $counter = 2;

            while (Service::where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
                $slug = $baseSlug.'-'.$counter;
                $counter++;
            }

            $data['slug'] = $slug;
        }

        $service->update($data);

        return redirect()->back();
    }

    public function destroy($id): RedirectResponse
    {
        $this->ensureAdmin();

        $service = Service::find($id);

        if (! $service) {
            return redirect()->back()->withErrors([
                'service' => 'The selected service could not be found.',
            ]);
        }

        $service->delete();

        return redirect()->back();
    }
}
