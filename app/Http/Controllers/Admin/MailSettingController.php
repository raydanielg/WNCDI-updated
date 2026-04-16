<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailSetting;
use App\Mail\TestEmail;
use App\Services\MailConfigService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class MailSettingController extends Controller
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

        $settings = MailSetting::query()->first();

        return Inertia::render('Admin/Settings/Mail', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'mailer' => ['nullable', 'string', 'max:50'],
            'host' => ['nullable', 'string', 'max:255'],
            'port' => ['nullable', 'integer'],
            'username' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'max:255'],
            'encryption' => ['nullable', 'string', 'max:50'],
            'from_address' => ['nullable', 'email', 'max:255'],
            'from_name' => ['nullable', 'string', 'max:255'],
        ]);

        $settings = MailSetting::query()->first() ?? new MailSetting();
        $settings->fill($data);
        $settings->save();

        return back()->with('success', 'Mail settings updated.');
    }

    public function sendTest(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'test_email' => ['required', 'email', 'max:255'],
        ]);

        try {
            MailConfigService::configure();
            
            Mail::to($data['test_email'])->send(new TestEmail());
            
            return back()->with('success', 'Test email sent successfully to ' . $data['test_email']);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
