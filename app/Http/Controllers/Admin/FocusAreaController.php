<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FocusArea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class FocusAreaController extends Controller
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

        $areas = FocusArea::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'title', 'description', 'icon', 'image_url', 'sort_order']);

        return Inertia::render('Admin/FocusAreas', [
            'areas' => $areas,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'file', 'max:10240', 'mimetypes:image/jpeg,image/png,image/webp,image/svg+xml,image/gif,image/bmp,image/tiff,image/x-tiff,image/heic'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('focus-areas', 'public');
            $data['image_url'] = Storage::url($path);
        }

        unset($data['image']);
        FocusArea::create($data);

        return redirect()->back();
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->ensureAdmin();

        $area = FocusArea::findOrFail($id);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'file', 'max:10240', 'mimetypes:image/jpeg,image/png,image/webp,image/svg+xml,image/gif,image/bmp,image/tiff,image/x-tiff,image/heic'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('focus-areas', 'public');
            $data['image_url'] = Storage::url($path);
        }

        unset($data['image']);
        $area->update($data);

        return redirect()->back();
    }

    public function destroy($id): RedirectResponse
    {
        $this->ensureAdmin();

        $area = FocusArea::find($id);

        if (! $area) {
            return redirect()->back()->withErrors([
                'focus' => 'The selected focus area could not be found.',
            ]);
        }

        $area->delete();

        return redirect()->back();
    }
}
