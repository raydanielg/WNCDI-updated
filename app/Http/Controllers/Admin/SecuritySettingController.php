<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecuritySetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SecuritySettingController extends Controller
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

        $settings = SecuritySetting::query()->first();

        return Inertia::render('Admin/Settings/Security', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'allow_registration' => ['nullable', 'boolean'],
            'password_min_length' => ['nullable', 'integer', 'min:6', 'max:64'],
            'login_rate_limit' => ['nullable', 'integer', 'min:1', 'max:100'],
            'two_factor_enabled' => ['nullable', 'boolean'],
        ]);

        $settings = SecuritySetting::query()->first() ?? new SecuritySetting();
        $settings->fill($data);
        $settings->allow_registration = (bool) ($data['allow_registration'] ?? true);
        $settings->two_factor_enabled = (bool) ($data['two_factor_enabled'] ?? false);
        $settings->save();

        return back()->with('success', 'Security settings updated.');
    }
}
