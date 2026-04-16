<?php

namespace App\Http\Controllers;

use App\Models\ForumRegistration;
use App\Mail\ForumRegistrationNotification;
use App\Mail\ForumRegistrationUserConfirmation;
use App\Services\MailConfigService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class ForumRegistrationController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('ForumRegistration');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'forum_name' => ['required', 'string', 'max:255'],
            'attendee_type' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'nationality' => ['required', 'string', 'max:255'],
            'organization' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'attendee_count' => ['required', 'integer', 'min:1'],
            'services' => ['required', 'array', 'min:1'],
            'services.*' => ['string', 'max:255'],
            'other_services' => ['nullable', 'string', 'max:255'],
            'attendance_days' => ['required', 'array', 'min:1'],
            'attendance_days.*' => ['string', 'max:50'],
            'booth' => ['required', 'string', 'max:50'],
            'sponsorship_package' => ['nullable', 'string', 'max:255'],
            'agree_terms' => ['required', 'boolean'],
        ]);

        $payload = $data;
        $payload['services'] = $data['services'] ?? [];
        $payload['attendance_days'] = $data['attendance_days'] ?? [];

        $data['status'] = 'pending';

        $registration = ForumRegistration::create($data);

        MailConfigService::configure();

        // Notify admin only at submission time
        Mail::to(config('mail.notification_email', 'info@wncdi.org'))
            ->send(new ForumRegistrationNotification($registration));

        return back()
            ->with('success', 'Thank you for registering for the forum.')
            ->with('registration_id', $registration->id);
    }

    public function preview(ForumRegistration $registration): Response
    {
        return Inertia::render('ForumRegistrationPreview', [
            'registration' => $registration,
        ]);
    }
}
