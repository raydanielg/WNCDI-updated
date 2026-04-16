<?php

namespace App\Console\Commands;

use App\Models\ForumRegistration;
use Illuminate\Console\Command;

class ImportForminatorForum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:forminator-forum {path : Path to tanfordu_wp115.json export} {--form-id=195 : Forminator form_id to import}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Forminator forum registrations from a WordPress JSON export into forum_registrations table';

    /**
     * Execute the console command.
     */
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

        // Locate the Forminator tables
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

        // Filter entries for the desired form_id
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

        // Group meta by entry_id
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

        $this->info('Importing forum registrations ...');

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
                // Meta values may contain <br> or <br/> separated items
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

            $attendeeType = $getSingle($meta, 'select-2');

            // Name priority: second, first, then third
            $name = $getSingle($meta, 'name-2')
                ?? $getSingle($meta, 'name-1')
                ?? $getSingle($meta, 'name-3');

            $email = $getSingle($meta, 'email-2')
                ?? $getSingle($meta, 'email-1');

            $phone = $getSingle($meta, 'phone-2')
                ?? $getSingle($meta, 'phone-1');

            // Address can be address-2 or address-1, stored as PHP serialized array
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

            $contactPerson = $getSingle($meta, 'name-3') ?? $name;
            $contactPhone = $getSingle($meta, 'phone-3') ?? $phone;
            $attendeeCount = $getSingle($meta, 'number-1');

            $services = $getJoined($meta, 'checkbox-2') ?? [];
            $attendanceDays = $getJoined($meta, 'checkbox-3') ?? [];
            $package = $getSingle($meta, 'checkbox-5');

            $consent = $getSingle($meta, 'consent-1');
            $agreeTerms = $consent === 'checked';

            if (! $email) {
                // Skip completely broken entries
                $this->warn("Skipping entry_id {$entryId} because it has no email.");
                continue;
            }

            $forumName = 'Tanzania Global Logistics Forum 2025';

            // Avoid creating duplicates based on the unique key (forum_name + email)
            $existing = ForumRegistration::query()
                ->where('forum_name', $forumName)
                ->where('email', $email)
                ->first();

            if ($existing) {
                $this->line("Skipping existing registration for {$email} ({$entryId}) - already imported.");
                continue;
            }

            $registration = new ForumRegistration();
            $registration->forum_name = $forumName;
            $registration->attendee_type = $attendeeType;
            $registration->name = $name;
            $registration->email = $email;
            $registration->phone = $phone;
            $registration->city = $city;
            $registration->country = $country;
            $registration->nationality = null; // not present in original form
            $registration->organization = $organization;
            $registration->contact_person = $contactPerson;
            $registration->job_title = $jobTitle;
            $registration->website = $website;
            $registration->contact_phone = $contactPhone;
            $registration->attendee_count = $attendeeCount !== null ? (int) $attendeeCount : null;
            $registration->services = $services;
            $registration->other_services = null;
            $registration->attendance_days = $attendanceDays;
            $registration->booth = null;
            // Column is NOT NULL in MySQL; default to empty string when no package selected
            $registration->sponsorship_package = $package ?? '';
            $registration->agree_terms = $agreeTerms;
            $registration->status = 'pending';

            $createdAt = $entry['date_created'] ?? null;
            if ($createdAt) {
                $registration->created_at = $createdAt;
                $registration->updated_at = $createdAt;
            }

            $registration->save();
            $imported++;
        }

        $this->info("Imported {$imported} forum registrations.");

        return self::SUCCESS;
    }
}
