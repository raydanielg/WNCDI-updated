<?php

namespace App\Exports;

use App\Models\UaeResident;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UaeResidentsExport implements FromCollection, WithHeadings
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
        return UaeResident::query()
            ->whereIn('id', $this->ids)
            ->orderByDesc('created_at')
            ->get([
                'id',
                'name',
                'email',
                'phone',
                'city',
                'country',
                'nationality',
                'job_title',
                'website',
                'attendee_type',
                'attendee_count',
                'package',
                'status',
                'created_at',
            ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'City',
            'Country',
            'Nationality',
            'Job title',
            'Website',
            'Attendee type',
            'Attendee count',
            'Package',
            'Status',
            'Created at',
        ];
    }
}
