<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SeoSettingController extends Controller
{
    protected function ensureAdmin(): void
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'admin') {
            abort(403);
        }
    }

    public function index(): Response
    {
        $this->ensureAdmin();

        $settings = SeoSetting::query()->first();

        return Inertia::render('Admin/Settings/Seo', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'default_meta_title' => ['nullable', 'string', 'max:255'],
            'default_meta_description' => ['nullable', 'string'],
            'default_meta_keywords' => ['nullable', 'string'],
            'og_image_url' => ['nullable', 'string', 'max:255'],
        ]);

        $settings = SeoSetting::query()->first() ?? new SeoSetting();
        $settings->fill($data);
        $settings->save();

        return back()->with('success', 'SEO settings updated.');
    }
}
