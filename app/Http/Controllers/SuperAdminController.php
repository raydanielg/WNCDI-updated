<?php

namespace App\Http\Controllers;

use App\Models\SecuritySetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SuperAdminController extends Controller
{
    public function panel(Request $request): Response|RedirectResponse
    {
        if (! $request->session()->get('is_superadmin')) {
            return redirect()->route('login');
        }

        $setting = SecuritySetting::query()->first();

        if (! $setting) {
            $setting = SecuritySetting::create([
                'allow_registration' => true,
                'password_min_length' => 8,
                'login_rate_limit' => 5,
                'two_factor_enabled' => false,
                'system_enabled' => true,
            ]);
        }

        return Inertia::render('SuperAdmin/Panel', [
            'systemEnabled' => (bool) $setting->system_enabled,
        ]);
    }

    public function toggleSystem(Request $request): RedirectResponse
    {
        if (! $request->session()->get('is_superadmin')) {
            return redirect()->route('login');
        }

        $request->validate([
            'system_enabled' => ['required', 'boolean'],
        ]);

        $setting = SecuritySetting::query()->first();

        if (! $setting) {
            $setting = new SecuritySetting();
        }

        $setting->fill([
            'system_enabled' => $request->boolean('system_enabled'),
        ]);

        if (! $setting->exists) {
            // Ensure sensible defaults for other fields if creating on the fly
            $setting->allow_registration = $setting->allow_registration ?? true;
            $setting->password_min_length = $setting->password_min_length ?? 8;
            $setting->login_rate_limit = $setting->login_rate_limit ?? 5;
            $setting->two_factor_enabled = $setting->two_factor_enabled ?? false;
        }

        $setting->save();

        return redirect()
            ->route('superadmin.panel')
            ->with('status', $setting->system_enabled ? 'System turned ON' : 'System turned OFF');
    }
}
