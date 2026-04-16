<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberOrganization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class MemberOrganizationController extends Controller
{
    protected function ensureAdmin(): void
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'admin') {
            abort(403);
        }
    }

    public function index(Request $request): Response
    {
        $this->ensureAdmin();

        $members = MemberOrganization::query()
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'logo_url',
                'created_at',
            ]);

        return Inertia::render('Admin/Members', [
            'members' => $members,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $memberData = [
            'name' => $data['name'],
        ];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('members', 'public');
            $memberData['logo_url'] = Storage::disk('public')->url($path);
        }

        MemberOrganization::create($memberData);

        return redirect()->back();
    }

    public function update(Request $request, MemberOrganization $member): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $updateData = [
            'name' => $data['name'],
        ];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('members', 'public');
            $updateData['logo_url'] = Storage::disk('public')->url($path);
        }

        $member->update($updateData);

        return redirect()->back();
    }

    public function destroy(MemberOrganization $member): RedirectResponse
    {
        $this->ensureAdmin();

        $member->delete();

        return redirect()->back();
    }
}
