<?php

namespace App\Http\Controllers;

use App\Models\UaeResident;
use App\Mail\UaeResidentNotification;
use App\Mail\UaeResidentUserConfirmation;
use App\Services\MailConfigService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class UaeResidentController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'attendee_type' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'nationality' => ['required', 'string', 'max:255'],
            'passport_number' => ['required', 'string', 'max:255'],
            'emirates_id' => ['required', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'website' => ['required', 'string', 'max:255'],
            'attendee_count' => ['required', 'integer', 'min:1'],
            'attendance_days' => ['required', 'array', 'min:1'],
            'attendance_days.*' => ['string', 'max:50'],
            'package' => ['required', 'string', 'max:255'],
            'agree_terms' => ['required', 'boolean'],
        ]);

        $data['attendance_days'] = $data['attendance_days'] ?? [];
        $data['status'] = 'pending';

        $resident = UaeResident::create($data);

        MailConfigService::configure();

        // Notify admin only at submission time
        Mail::to(config('mail.notification_email', 'info@wncdi.org'))
            ->send(new UaeResidentNotification($resident));

        return back()
            ->with('success', 'Thank you for registering as a UAE resident attendee.')
            ->with('resident_id', $resident->id);
    }

    public function preview(UaeResident $resident): Response
    {
        return Inertia::render('UaeResidentPreview', [
            'resident' => $resident,
        ]);
    }
}
