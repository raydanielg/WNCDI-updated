<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        NewsletterSubscription::firstOrCreate([
            'email' => $data['email'],
        ], [
            'name' => $data['name'] ?? null,
        ]);

        return back()->with('newsletter_success', 'Thank you for subscribing.');
    }
}
