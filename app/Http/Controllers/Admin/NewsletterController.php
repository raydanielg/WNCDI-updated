<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NewsletterController extends Controller
{
    protected function ensureAdmin(): void
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $subscriptions = NewsletterSubscription::query()
            ->latest('created_at')
            ->get(['id', 'email', 'name', 'created_at']);

        return Inertia::render('Admin/Newsletter', [
            'subscriptions' => $subscriptions,
        ]);
    }
}
