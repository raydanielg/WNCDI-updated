<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'organization_name',
        'organization_description',
        'tagline',
        'vision',
        'mission',
        'about_text',
        'default_email',
        'default_phone',
        'primary_email',
        'primary_phone',
        'secondary_phone',
        'default_language',
        'timezone',
        'maintenance_mode',
        'logo_url',
        'registration_number',
        'founding_year',
        'bank_name',
        'bank_account',
        'bank_account_name',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
    ];
}
