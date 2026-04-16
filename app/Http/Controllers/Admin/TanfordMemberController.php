<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TanfordMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TanfordMemberController extends Controller
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

        $members = TanfordMember::query()
            ->latest('created_at')
            ->get([
                'id',
                'full_name',
                'email',
                'whatsapp',
                'company_name',
                'country_of_registration',
                'status',
                'created_at',
            ]);

        return Inertia::render('Admin/TanfordMembers', [
            'members' => $members,
        ]);
    }

    public function show(TanfordMember $member): Response
    {
        $this->ensureAdmin();

        $member->refresh();

        return Inertia::render('Admin/TanfordMemberShow', [
            'member' => $member,
        ]);
    }

    public function updateStatus(TanfordMember $member): RedirectResponse
    {
        $this->ensureAdmin();

        request()->validate([
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
        ]);

        $member->status = request('status');
        $member->save();

        return back();
    }
}
