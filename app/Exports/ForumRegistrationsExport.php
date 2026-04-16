<?php

namespace App\Exports;

use App\Models\ForumRegistration;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ForumRegistrationsExport implements FromCollection, WithHeadings
{
    /** @var array<int,int> */
    protected array $ids;

    /**
     * @param array<int,int> $ids
     */
    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    public function collection(): Collection
    {
        return ForumRegistration::query()
            ->whereIn('id', $this->ids)
            ->orderByDesc('created_at')
            ->get([
                'id',
                'forum_name',
                'name',
                'email',
                'phone',
                'country',
                'nationality',
                'organization',
                'job_title',
                'website',
                'attendee_count',
                'attendee_type',
                'booth',
                'sponsorship_package',
                'status',
                'created_at',
            ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Forum',
            'Name',
            'Email',
            'Phone',
            'Country of residence',
            'Nationality',
            'Organization',
            'Job title',
            'Website',
            'Attendee count',
            'Attendee type',
            'Booth',
            'Package',
            'Status',
            'Created at',
        ];
    }
}
