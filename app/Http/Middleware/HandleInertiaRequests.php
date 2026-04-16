<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\User;
use App\Models\ForumRegistration;
use App\Models\UaeResident;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $shared = [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
        ];

        $user = $request->user();

        if ($user && $user->role === 'admin') {
            $since = $user->admin_last_seen_notifications_at;

            $items = collect();

            // New user signups
            $newUsers = User::query()
                ->where('id', '!=', $user->id)
                ->when($since, function ($query) use ($since) {
                    $query->where('created_at', '>', $since);
                })
                ->latest('created_at')
                ->take(5)
                ->get(['id', 'name', 'email', 'created_at']);

            foreach ($newUsers as $u) {
                $items->push([
                    'id' => 'user-'.$u->id,
                    'type' => 'user_signup',
                    'title' => 'New user signup',
                    'message' => $u->name.' · '.$u->email,
                    'created_at' => $u->created_at,
                ]);
            }

            // New forum registrations
            $newForum = ForumRegistration::query()
                ->when($since, function ($query) use ($since) {
                    $query->where('created_at', '>', $since);
                })
                ->latest('created_at')
                ->take(5)
                ->get(['id', 'forum_name', 'name', 'email', 'created_at']);

            foreach ($newForum as $reg) {
                $items->push([
                    'id' => 'forum-'.$reg->id,
                    'type' => 'forum_registration',
                    'title' => 'New forum registration',
                    'message' => ($reg->forum_name ?: 'Forum').': '.$reg->name.' · '.$reg->email,
                    'created_at' => $reg->created_at,
                ]);
            }

            // New UAE residents registrations
            $newUae = UaeResident::query()
                ->when($since, function ($query) use ($since) {
                    $query->where('created_at', '>', $since);
                })
                ->latest('created_at')
                ->take(5)
                ->get(['id', 'name', 'email', 'city', 'created_at']);

            foreach ($newUae as $resident) {
                $items->push([
                    'id' => 'uae-'.$resident->id,
                    'type' => 'uae_resident',
                    'title' => 'New UAE resident form',
                    'message' => $resident->name.' · '.$resident->email.($resident->city ? ' · '.$resident->city : ''),
                    'created_at' => $resident->created_at,
                ]);
            }

            $items = $items
                ->sortByDesc('created_at')
                ->values()
                ->take(10);

            $shared['adminNotifications'] = [
                'items' => $items,
                'unreadCount' => $items->count(),
            ];
        }

        return $shared;
    }
}
