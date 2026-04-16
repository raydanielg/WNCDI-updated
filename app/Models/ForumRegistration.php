<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_name',
        'attendee_type',
        'name',
        'email',
        'phone',
        'city',
        'country',
        'nationality',
        'organization',
        'contact_person',
        'job_title',
        'website',
        'contact_phone',
        'attendee_count',
        'services',
        'other_services',
        'attendance_days',
        'booth',
        'sponsorship_package',
        'agree_terms',
        'status',
    ];

    protected $casts = [
        'services' => 'array',
        'attendance_days' => 'array',
        'agree_terms' => 'boolean',
        'status' => 'string',
    ];
}
