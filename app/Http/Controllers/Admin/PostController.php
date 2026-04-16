<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
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

        $posts = Post::query()
            ->orderByDesc('created_at')
            ->get([
                'id',
                'title',
                'slug',
                'category',
                'author_name',
                'image_url',
                'excerpt',
                'body',
                'published_at',
                'created_at',
            ]);

        return Inertia::render('Admin/Posts', [
            'posts' => $posts,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'author_name' => ['nullable', 'string', 'max:100'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:4096'],
            'body_image' => ['nullable', 'image', 'max:4096'],
            'body_audio' => ['nullable', 'mimetypes:audio/mpeg,audio/mp3,audio/wav', 'max:10240'],
            'body_video' => ['nullable', 'mimetypes:video/mp4,video/webm', 'max:20480'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'published' => ['nullable', 'boolean'],
        ]);

        $published = (bool) ($data['published'] ?? false);
        unset($data['published']);

        // Handle featured image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $data['image_url'] = Storage::url($path);
        }

        // Append media to body as simple HTML blocks
        $bodyHtml = $data['body'] ?? '';

        if ($request->hasFile('body_image')) {
            $path = $request->file('body_image')->store('posts', 'public');
            $url = e(Storage::url($path));
            $bodyHtml .= "\n\n<p><img src=\"{$url}\" alt=\"" . e($data['title']) . "\" style=\"max-width:100%;height:auto;\"></p>";
        }

        if ($request->hasFile('body_audio')) {
            $path = $request->file('body_audio')->store('posts', 'public');
            $url = e(Storage::url($path));
            $bodyHtml .= "\n\n<p><audio controls src=\"{$url}\" style=\"width:100%;\">Your browser does not support the audio element.</audio></p>";
        }

        if ($request->hasFile('body_video')) {
            $path = $request->file('body_video')->store('posts', 'public');
            $url = e(Storage::url($path));
            $bodyHtml .= "\n\n<p><video controls src=\"{$url}\" style=\"max-width:100%;height:auto;\">Your browser does not support the video tag.</video></p>";
        }

        $data['body'] = $bodyHtml;

        unset($data['image'], $data['body_image'], $data['body_audio'], $data['body_video']);

        $data['published_at'] = $published ? now() : null;

        Post::create($data);

        return redirect()->back();
    }

    public function create(Request $request): Response
    {
        $this->ensureAdmin();

        return Inertia::render('Admin/PostCreate');
    }

    public function edit(Request $request, Post $post): Response
    {
        $this->ensureAdmin();

        return Inertia::render('Admin/PostEdit', [
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'category' => $post->category,
                'author_name' => $post->author_name,
                'image_url' => $post->image_url,
                'excerpt' => $post->excerpt,
                'body' => $post->body,
                'published_at' => $post->published_at,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ],
        ]);
    }

    public function update(Request $request, $postId): RedirectResponse
    {
        $this->ensureAdmin();

        $post = Post::find($postId);

        if (! $post) {
            return redirect()->back()->withErrors([
                'post' => 'The selected post could not be found. It may have been deleted.',
            ]);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'author_name' => ['nullable', 'string', 'max:100'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:4096'],
            'body_image' => ['nullable', 'image', 'max:4096'],
            'body_audio' => ['nullable', 'mimetypes:audio/mpeg,audio/mp3,audio/wav', 'max:10240'],
            'body_video' => ['nullable', 'mimetypes:video/mp4,video/webm', 'max:20480'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'published' => ['nullable', 'boolean'],
        ]);

        $published = (bool) ($data['published'] ?? false);
        unset($data['published']);

        // Featured image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $data['image_url'] = Storage::url($path);
        }

        // Append new media blocks to existing/new body
        $bodyHtml = $data['body'] ?? $post->body ?? '';

        if ($request->hasFile('body_image')) {
            $path = $request->file('body_image')->store('posts', 'public');
            $url = e(Storage::url($path));
            $bodyHtml .= "\n\n<p><img src=\"{$url}\" alt=\"" . e($data['title']) . "\" style=\"max-width:100%;height:auto;\"></p>";
        }

        if ($request->hasFile('body_audio')) {
            $path = $request->file('body_audio')->store('posts', 'public');
            $url = e(Storage::url($path));
            $bodyHtml .= "\n\n<p><audio controls src=\"{$url}\" style=\"width:100%;\">Your browser does not support the audio element.</audio></p>";
        }

        if ($request->hasFile('body_video')) {
            $path = $request->file('body_video')->store('posts', 'public');
            $url = e(Storage::url($path));
            $bodyHtml .= "\n\n<p><video controls src=\"{$url}\" style=\"max-width:100%;height:auto;\">Your browser does not support the video tag.</video></p>";
        }

        $data['body'] = $bodyHtml;

        unset($data['image'], $data['body_image'], $data['body_audio'], $data['body_video']);

        $data['published_at'] = $published ? now() : null;

        $post->update($data);

        return redirect()->back();
    }

    public function destroy($postId): RedirectResponse
    {
        $this->ensureAdmin();

        $post = Post::find($postId);

        if (! $post) {
            return redirect()->back()->withErrors([
                'post' => 'The selected post could not be found. It may have been deleted.',
            ]);
        }

        $post->delete();

        return redirect()->back();
    }
}
