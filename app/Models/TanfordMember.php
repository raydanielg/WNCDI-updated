<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanfordMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'date',
        'nationality',
        'passport_or_id',
        'whatsapp',
        'email',
        'company_name',
        'country_of_registration',
        'business_location',
        'services',
        'other_services',
        'registration_number',
        'tin',
        'willing_to_join',
        'reason',
        'agree_terms',
        'signature_name',
        'status',
    ];

    protected $casts = [
        'services' => 'array',
        'willing_to_join' => 'boolean',
        'agree_terms' => 'boolean',
        'status' => 'string',
    ];
}
