<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class TeamMemberController extends Controller
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

        $members = TeamMember::query()
            ->orderByDesc('created_at')
            ->get([
                'id',
                'name',
                'title',
                'bio',
                'photo_url',
                'facebook_url',
                'twitter_url',
                'created_at',
            ]);

        return Inertia::render('Admin/TeamMembers', [
            'teamMembers' => $members,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:4096'],
            'photo_url' => ['nullable', 'string', 'max:255'],
            'facebook_url' => ['nullable', 'string', 'max:255'],
            'twitter_url' => ['nullable', 'string', 'max:255'],
        ]);

        $memberData = [
            'name' => $data['name'],
            'title' => $data['title'] ?? null,
            'bio' => $data['bio'] ?? null,
            'photo_url' => $data['photo_url'] ?? null,
            'facebook_url' => $data['facebook_url'] ?? null,
            'twitter_url' => $data['twitter_url'] ?? null,
        ];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('team', 'public');
            $memberData['photo_url'] = Storage::disk('public')->url($path);
        }

        TeamMember::create($memberData);

        return redirect()->back();
    }

    public function update(Request $request, TeamMember $teamMember): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:4096'],
            'photo_url' => ['nullable', 'string', 'max:255'],
            'facebook_url' => ['nullable', 'string', 'max:255'],
            'twitter_url' => ['nullable', 'string', 'max:255'],
        ]);

        $updateData = [
            'name' => $data['name'],
            'title' => $data['title'] ?? null,
            'bio' => $data['bio'] ?? null,
            'photo_url' => $data['photo_url'] ?? null,
            'facebook_url' => $data['facebook_url'] ?? null,
            'twitter_url' => $data['twitter_url'] ?? null,
        ];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('team', 'public');
            $updateData['photo_url'] = Storage::disk('public')->url($path);
        }

        $teamMember->update($updateData);

        return redirect()->back();
    }

    public function destroy(TeamMember $teamMember): RedirectResponse
    {
        $this->ensureAdmin();

        $teamMember->delete();

        return redirect()->back();
    }
}
