<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class MediaItemController extends Controller
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

        $items = MediaItem::query()
            ->latest('created_at')
            ->get(['id', 'title', 'type', 'file_url', 'thumbnail_url', 'description', 'created_at']);

        return Inertia::render('Admin/Media', [
            'items' => $items,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'file' => ['required', 'file', 'max:51200', 'mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/webm'],
        ]);

        $file = $request->file('file');
        $mime = $file->getMimeType();
        $type = str_starts_with($mime, 'image/') ? 'image' : (str_starts_with($mime, 'video/') ? 'video' : 'other');

        $path = $file->store('media', 'public');
        $fileUrl = Storage::url($path);

        MediaItem::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'type' => $type,
            'file_url' => $fileUrl,
            'thumbnail_url' => null,
        ]);

        return redirect()->back();
    }

    public function destroy($id): RedirectResponse
    {
        $this->ensureAdmin();

        $item = MediaItem::find($id);

        if (! $item) {
            return redirect()->back()->withErrors([
                'media' => 'The selected media item could not be found.',
            ]);
        }

        $item->delete();

        return redirect()->back();
    }
}
