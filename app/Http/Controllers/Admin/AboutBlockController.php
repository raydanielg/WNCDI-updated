<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutBlock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class AboutBlockController extends Controller
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

        $about = AboutBlock::query()->first();

        if (! $about) {
            $about = AboutBlock::create([
                'badge_label' => 'About WNCDi',
                'title_line1' => 'Empowering Communities',
                'title_line2' => 'Through Health Education',
                'intro_text' => 'WNCDi is dedicated to diabetes awareness, health education, and community wellness. We provide evidence-based programs and resources to promote healthier lifestyles across our communities.',
                'bullet1' => 'Comprehensive diabetes awareness and prevention programs.',
                'bullet2' => 'Evidence-based health education for families and healthcare providers.',
                'bullet3' => 'Community-driven wellness initiatives and health screening events.',
                'cta_label' => 'Learn More',
                'cta_url' => '/about',
                'experience_label' => 'Committed to',
                'experience_text' => 'Community Health & Wellness',
            ]);
        }

        return Inertia::render('Admin/AboutBlock', [
            'about' => $about,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $about = AboutBlock::query()->firstOrFail();

        $data = $request->validate([
            'badge_label' => ['nullable', 'string', 'max:255'],
            'title_line1' => ['nullable', 'string', 'max:255'],
            'title_line2' => ['nullable', 'string', 'max:255'],
            'intro_text' => ['nullable', 'string'],
            'bullet1' => ['nullable', 'string', 'max:255'],
            'bullet2' => ['nullable', 'string', 'max:255'],
            'bullet3' => ['nullable', 'string', 'max:255'],
            'cta_label' => ['nullable', 'string', 'max:255'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'experience_label' => ['nullable', 'string', 'max:255'],
            'experience_text' => ['nullable', 'string', 'max:255'],
            'left_image' => ['nullable', 'image', 'max:4096'],
            'right_image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('left_image')) {
            $path = $request->file('left_image')->store('about', 'public');
            $data['left_image_url'] = Storage::url($path);
        }

        if ($request->hasFile('right_image')) {
            $path = $request->file('right_image')->store('about', 'public');
            $data['right_image_url'] = Storage::url($path);
        }

        unset($data['left_image'], $data['right_image']);

        $about->update($data);

        return redirect()->back();
    }
}
