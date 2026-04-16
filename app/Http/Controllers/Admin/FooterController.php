<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FooterController extends Controller
{
    protected function ensureAdmin(): void
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $setting = FooterSetting::query()->first();

        return Inertia::render('Admin/Footer', [
            'footer' => $setting,
        ]);
    }

    public function update(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'description' => ['nullable', 'string'],
            'services_list' => ['nullable', 'string'],
            'facebook_url' => ['nullable', 'url'],
            'twitter_url' => ['nullable', 'url'],
            'linkedin_url' => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'quick_link1_label' => ['nullable', 'string', 'max:255'],
            'quick_link1_url' => ['nullable', 'url'],
            'quick_link2_label' => ['nullable', 'string', 'max:255'],
            'quick_link2_url' => ['nullable', 'url'],
            'quick_link3_label' => ['nullable', 'string', 'max:255'],
            'quick_link3_url' => ['nullable', 'url'],
            'newsletter_text' => ['nullable', 'string'],
            'newsletter_button_label' => ['nullable', 'string', 'max:255'],
            'privacy_url' => ['nullable', 'url'],
            'terms_url' => ['nullable', 'url'],
            'copyright_text' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $setting = FooterSetting::query()->first() ?? new FooterSetting();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('footer', 'public');
            $data['logo_url'] = Storage::disk('public')->url($path);
        }

        $setting->fill($data);
        $setting->save();

        return redirect()->back();
    }
}
