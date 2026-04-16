<?php

namespace App\Console\Commands;

use App\Models\UaeResident;
use Illuminate\Console\Command;

class ImportForminatorUaeResidents extends Command
{
    protected $signature = 'import:forminator-uae {path : Path to tanfordu_wp115.json export} {--form-id=325 : Forminator form_id to import}';

    protected $description = 'Import Forminator UAE Residents registrations from a WordPress JSON export into uae_residents table';

    public function handle(): int
    {
        $path = $this->argument('path');
        $formId = (string) $this->option('form-id');

        if (! is_file($path)) {
            $this->error("File not found: {$path}");
            return self::FAILURE;
        }

        $this->info("Loading JSON export from {$path} ...");

        $json = file_get_contents($path);
        if ($json === false) {
            $this->error('Failed to read JSON file.');
            return self::FAILURE;
        }

        $data = json_decode($json, true);
        if (! is_array($data)) {
            $this->error('Invalid JSON structure.');
            return self::FAILURE;
        }

        $entryRows = [];
        $metaRows = [];

        foreach ($data as $section) {
            if (! is_array($section)) {
                continue;
            }

            if (($section['type'] ?? null) !== 'table') {
                continue;
            }

            if (! isset($section['name'], $section['data']) || ! is_array($section['data'])) {
                continue;
            }

            switch ($section['name']) {
                case 'wpgs_frmt_form_entry':
                    $entryRows = $section['data'];
                    break;
                case 'wpgs_frmt_form_entry_meta':
                    $metaRows = $section['data'];
                    break;
            }
        }

        if (empty($entryRows) || empty($metaRows)) {
            $this->error('Could not find Forminator tables (wpgs_frmt_form_entry / wpgs_frmt_form_entry_meta) in JSON.');
            return self::FAILURE;
        }

        $entriesForForm = [];
        foreach ($entryRows as $row) {
            if (! is_array($row)) {
                continue;
            }

            if (($row['form_id'] ?? null) === $formId && ($row['status'] ?? null) === 'active' && ($row['is_spam'] ?? '0') === '0') {
                $entryId = (string) ($row['entry_id'] ?? '');
                if ($entryId !== '') {
                    $entriesForForm[$entryId] = $row;
                }
            }
        }

        if (empty($entriesForForm)) {
            $this->warn("No entries found for form_id {$formId}.");
            return self::SUCCESS;
        }

        $metaByEntry = [];
        foreach ($metaRows as $row) {
            if (! is_array($row)) {
                continue;
            }
            $entryId = isset($row['entry_id']) ? (string) $row['entry_id'] : '';
            if ($entryId === '') {
                continue;
            }
            $key = (string) ($row['meta_key'] ?? '');
            $value = $row['meta_value'] ?? null;
            if ($key === '') {
                continue;
            }
            $metaByEntry[$entryId][$key][] = $value;
        }

        $this->info('Importing UAE Residents registrations ...');

        $imported = 0;

        foreach ($entriesForForm as $entryId => $entry) {
            $meta = $metaByEntry[$entryId] ?? [];

            $getSingle = function (array $meta, string $key): ?string {
                if (! isset($meta[$key]) || ! is_array($meta[$key]) || $meta[$key] === []) {
                    return null;
                }
                return (string) ($meta[$key][0] ?? null);
            };

            $getJoined = function (array $meta, string $key): ?array {
                if (! isset($meta[$key]) || ! is_array($meta[$key]) || $meta[$key] === []) {
                    return null;
                }
                $raw = (string) ($meta[$key][0] ?? '');
                if ($raw === '') {
                    return [];
                }
                $parts = preg_split('/<br\s*\/?>(?:\s*)/i', $raw) ?: [];
                $clean = [];
                foreach ($parts as $part) {
                    $trimmed = trim($part);
                    if ($trimmed !== '') {
                        $clean[] = $trimmed;
                    }
                }
                return $clean;
            };

            // NOTE: Hapa tunategemea structure ya form ya UAE Residents ya zamani
            // Hatujui kikamilifu meta_key zote, lakini tutatumia zile za msingi
            $attendeeType = $getSingle($meta, 'select-2');
            $fullName = $getSingle($meta, 'name-2')
                ?? $getSingle($meta, 'name-1')
                ?? $getSingle($meta, 'name-3');
            $email = $getSingle($meta, 'email-2')
                ?? $getSingle($meta, 'email-1');
            $phone = $getSingle($meta, 'phone-2')
                ?? $getSingle($meta, 'phone-1');

            $city = null;
            $country = null;
            $addressRaw = $getSingle($meta, 'address-2') ?? $getSingle($meta, 'address-1');
            if ($addressRaw) {
                $unserialized = @unserialize($addressRaw);
                if (is_array($unserialized)) {
                    $city = isset($unserialized['city']) ? (string) $unserialized['city'] : null;
                    $country = isset($unserialized['country']) ? (string) $unserialized['country'] : null;
                }
            }

            $organization = $getSingle($meta, 'text-1');
            $jobTitle = $getSingle($meta, 'text-2');
            $website = $getSingle($meta, 'url-1');

            $attendanceDays = $getJoined($meta, 'checkbox-3') ?? [];
            $package = $getSingle($meta, 'checkbox-5');

            $consent = $getSingle($meta, 'consent-1');
            $agreeTerms = $consent === 'checked';

            if (! $email) {
                $this->warn("Skipping entry_id {$entryId} because it has no email.");
                continue;
            }

            // Avoid duplicates based on email + created date (UAE residents form haina unique key ya forum_name)
            $createdAt = $entry['date_created'] ?? null;

            $existing = UaeResident::query()
                ->where('email', $email)
                ->when($createdAt, function ($q) use ($createdAt) {
                    $q->whereDate('created_at', '=', substr($createdAt, 0, 10));
                })
                ->first();

            if ($existing) {
                $this->line("Skipping existing UAE resident for {$email} ({$entryId}).");
                continue;
            }

            $resident = new UaeResident();
            $resident->attendee_type = $attendeeType;
            $resident->name = $fullName;
            $resident->email = $email;
            $resident->phone = $phone;
            $resident->city = $city;
            $resident->country = $country;
            $resident->nationality = null; // hatuna data ya moja kwa moja
            // Columns may be NOT NULL in the database, so default to empty strings
            $resident->passport_number = '';
            $resident->emirates_id = '';
            $resident->job_title = $jobTitle;
            $resident->organization = $organization;
            $resident->website = $website;
            $resident->attendance_days = $attendanceDays;
            $resident->package = $package;
            $resident->agree_terms = $agreeTerms;
            $resident->status = 'pending';

            if ($createdAt) {
                $resident->created_at = $createdAt;
                $resident->updated_at = $createdAt;
            }

            $resident->save();
            $imported++;
        }

        $this->info("Imported {$imported} UAE residents.");

        return self::SUCCESS;
    }
}
