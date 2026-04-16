<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportWpBlogs extends Command
{
    protected $signature = 'import:wp-blogs {path : Path to tanfordu_wp115.json export}';

    protected $description = 'Import WordPress blog posts (wpgs_posts, type=post) into Laravel Post model';

    public function handle(): int
    {
        $path = $this->argument('path');

        if (! is_file($path)) {
            $this->error("File not found: {$path}");
            return self::FAILURE;
        }

        $this->info("Loading JSON export from {$path} ...");

        $json = file_get_contents($path);
        if ($json === false) {
            $this->error('Failed to read JSON file.');
            return self::FAILURE;
        }

        $data = json_decode($json, true);
        if (! is_array($data)) {
            $this->error('Invalid JSON structure.');
            return self::FAILURE;
        }

        $postRows = [];

        foreach ($data as $section) {
            if (! is_array($section)) {
                continue;
            }

            if (($section['type'] ?? null) !== 'table') {
                continue;
            }

            if (($section['name'] ?? null) === 'wpgs_posts' && isset($section['data']) && is_array($section['data'])) {
                $postRows = $section['data'];
                break;
            }
        }

        if (empty($postRows)) {
            $this->error('Could not find wpgs_posts table in JSON.');
            return self::FAILURE;
        }

        $this->info('Importing blog posts ...');

        $imported = 0;

        foreach ($postRows as $row) {
            if (! is_array($row)) {
                continue;
            }

            // Only import real blog posts
            if (($row['post_type'] ?? '') !== 'post') {
                continue;
            }

            if (($row['post_status'] ?? '') !== 'publish') {
                continue;
            }

            $title = trim((string) ($row['post_title'] ?? ''));
            $content = (string) ($row['post_content'] ?? '');

            if ($title === '' && $content === '') {
                // Skip empty shells
                continue;
            }

            $slug = trim((string) ($row['post_name'] ?? ''));
            if ($slug === '') {
                $slug = Str::slug($title ?: Str::random(8));
            }

            // Avoid duplicates based on slug (route key for Post model)
            $existing = Post::query()->where('slug', $slug)->first();
            if ($existing) {
                $this->line("Skipping existing blog post with slug {$slug}.");
                continue;
            }

            $excerpt = trim((string) ($row['post_excerpt'] ?? ''));
            if ($excerpt === '' && $content !== '') {
                $plain = strip_tags($content);
                $excerpt = Str::limit(trim($plain), 200);
            }

            $publishedAt = $row['post_date'] ?? null;

            $post = new Post();
            $post->title = $title !== '' ? $title : 'Untitled Post';
            $post->slug = $slug;
            $post->excerpt = $excerpt;
            $post->body = $content;
            $post->category = 'blog';

            // We do not have author names mapped, default to Admin
            $post->author_name = 'Admin';

            // Image will not be resolved from content automatically here
            $post->image_url = null;

            if ($publishedAt && $publishedAt !== '0000-00-00 00:00:00') {
                $post->published_at = $publishedAt;
                $post->created_at = $publishedAt;
                $post->updated_at = $publishedAt;
            }

            $post->save();
            $imported++;
        }

        $this->info("Imported {$imported} blog posts.");

        return self::SUCCESS;
    }
}
