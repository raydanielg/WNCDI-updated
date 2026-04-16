<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class GeneralSettingController extends Controller
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

        $settings = GeneralSetting::query()->first();

        return Inertia::render('Admin/Settings/General', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'default_email' => ['nullable', 'email', 'max:255'],
            'default_phone' => ['nullable', 'string', 'max:50'],
            'default_language' => ['nullable', 'string', 'max:10'],
            'timezone' => ['nullable', 'string', 'max:100'],
            'maintenance_mode' => ['nullable', 'boolean'],
        ]);

        $settings = GeneralSetting::query()->first() ?? new GeneralSetting();
        $settings->fill($data);
        $settings->maintenance_mode = (bool) ($data['maintenance_mode'] ?? false);
        $settings->save();

        return back()->with('success', 'General settings updated.');
    }
}
