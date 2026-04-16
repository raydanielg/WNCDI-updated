<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UaeResident extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendee_type',
        'name',
        'email',
        'phone',
        'city',
        'country',
        'nationality',
        'passport_number',
        'emirates_id',
        'job_title',
        'organization',
        'website',
        'attendee_count',
        'attendance_days',
        'package',
        'agree_terms',
        'status',
    ];

    protected $casts = [
        'attendance_days' => 'array',
        'agree_terms' => 'boolean',
        'status' => 'string',
    ];
}
