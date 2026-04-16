<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        $services = Service::query()
            ->latest('created_at')
            ->get(['id', 'title', 'slug', 'short_description', 'body', 'image_url', 'created_at']);

        return Inertia::render('Services', [
            'services' => $services,
        ]);
    }
}
