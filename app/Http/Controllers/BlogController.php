<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\MediaItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(Request $request): Response
    {
        $posts = Post::query()
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->get();

        $recentTitles = $posts->take(5)->pluck('title')->values();

        // Use gallery images from MediaItem instead of post images
        $galleryImages = MediaItem::query()
            ->where('type', 'image')
            ->latest('created_at')
            ->take(4)
            ->pluck('file_url')
            ->values();

        return Inertia::render('Blog', [
            'posts' => $posts,
            'recentPosts' => $recentTitles,
            'galleryImages' => $galleryImages,
        ]);
    }

    public function show(Post $post): Response
    {
        $related = Post::query()
            ->where('id', '!=', $post->id)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(2)
            ->get(['id', 'title', 'image_url', 'slug']);

        $recentTitles = Post::query()
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(5)
            ->pluck('title')
            ->values();

        // Gallery images from MediaItem for detail page as well
        $galleryImages = MediaItem::query()
            ->where('type', 'image')
            ->latest('created_at')
            ->take(4)
            ->pluck('file_url')
            ->values();

        return Inertia::render('BlogDetail', [
            'post' => $post,
            'relatedPosts' => $related,
            'recentPosts' => $recentTitles,
            'galleryImages' => $galleryImages,
        ]);
    }
}
