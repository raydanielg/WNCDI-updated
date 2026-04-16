<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecuritySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'allow_registration',
        'password_min_length',
        'login_rate_limit',
        'two_factor_enabled',
        'system_enabled',
    ];

    protected $casts = [
        'allow_registration' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'system_enabled' => 'boolean',
    ];
}
