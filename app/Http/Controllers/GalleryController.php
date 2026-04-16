<?php

namespace App\Http\Controllers;

use App\Models\MediaItem;
use Inertia\Inertia;
use Inertia\Response;

class GalleryController extends Controller
{
    public function index(): Response
    {
        $items = MediaItem::query()
            ->latest('created_at')
            ->get(['id', 'title', 'type', 'file_url', 'thumbnail_url', 'description', 'created_at']);

        return Inertia::render('Gallery', [
            'mediaItems' => $items,
        ]);
    }
}
