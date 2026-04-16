<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UaeResident;
use App\Exports\UaeResidentsExport;
use App\Mail\UaeResidentApproved;
use App\Mail\UaeResidentApprovedAdmin;
use App\Services\MailConfigService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Inertia\Inertia;
use Inertia\Response;

class UaeResidentController extends Controller
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

        $residents = UaeResident::query()
            ->latest('created_at')
            ->get([
                'id',
                'name',
                'email',
                'phone',
                'city',
                'country',
                'nationality',
                'package',
                'status',
                'created_at',
            ]);

        return Inertia::render('Admin/UaeResidents', [
            'residents' => $residents,
        ]);
    }

    public function updateStatus(UaeResident $resident): RedirectResponse
    {
        $this->ensureAdmin();

        request()->validate([
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
        ]);

        $oldStatus = $resident->status;
        $newStatus = request('status');

        $resident->status = $newStatus;
        $resident->save();

        if ($oldStatus !== 'approved' && $newStatus === 'approved') {
            MailConfigService::configure();
            
            Mail::to($resident->email)
                ->send(new UaeResidentApproved($resident));
            
            Mail::to(config('mail.notification_email', 'info@wncdi.org'))
                ->send(new UaeResidentApprovedAdmin($resident));
        }

        return back();
    }

    public function export(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
            'format' => ['required', 'string', 'in:pdf,excel'],
        ]);

        $ids = $data['ids'];

        if ($data['format'] === 'excel') {
            return Excel::download(new UaeResidentsExport($ids), 'uae-residents.xlsx');
        }

        $residents = UaeResident::query()
            ->whereIn('id', $ids)
            ->orderByDesc('created_at')
            ->get([
                'name',
                'email',
                'phone',
                'city',
                'country',
                'nationality',
                'package',
                'status',
                'created_at',
            ]);

        $html = view('exports.uae_residents_pdf', [
            'residents' => $residents,
        ])->render();

        return Pdf::loadHTML($html)->download('uae-residents.pdf');
    }
}
