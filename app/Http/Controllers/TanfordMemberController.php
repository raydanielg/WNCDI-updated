<?php

namespace App\Http\Controllers;

use App\Mail\TanfordMemberWelcome;
use App\Models\TanfordMember;
use App\Services\MailConfigService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class TanfordMemberController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
            'nationality' => ['required', 'string', 'max:255'],
            'passport_or_id' => ['required', 'string', 'max:255', 'unique:tanford_members,passport_or_id'],
            'whatsapp' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255', 'unique:tanford_members,email'],
            'company_name' => ['required', 'string', 'max:255'],
            'country_of_registration' => ['required', 'string', 'max:255'],
            'business_location' => ['required', 'string', 'max:255'],
            'services' => ['nullable', 'array'],
            'services.*' => ['string', 'max:255'],
            'other_services' => ['nullable', 'string', 'max:255'],
            'registration_number' => ['required', 'string', 'max:255'],
            'tin' => ['nullable', 'string', 'max:255'],
            'willing_to_join' => ['required', 'boolean'],
            'reason' => ['nullable', 'string'],
            'agree_terms' => ['required', 'boolean'],
            'signature_name' => ['required', 'string', 'max:255'],
        ]);

        $data['services'] = $data['services'] ?? [];
        $data['status'] = 'pending';

        $member = TanfordMember::create($data);

        // Configure mail and send welcome email to the new member
        if (! empty($member->email)) {
            MailConfigService::configure();

            Mail::to($member->email)
                ->send(new TanfordMemberWelcome($member));
        }

        return back()
            ->with('success', 'Thank you for registering as a TANFORD member.')
            ->with('member_id', $member->id);
    }

    public function preview(TanfordMember $member): Response
    {
        return Inertia::render('TanfordMemberPreview', [
            'member' => $member,
        ]);
    }
}
