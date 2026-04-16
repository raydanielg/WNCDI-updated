<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo_url',
        'description',
        'services_list',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'instagram_url',
        'quick_link1_label',
        'quick_link1_url',
        'quick_link2_label',
        'quick_link2_url',
        'quick_link3_label',
        'quick_link3_url',
        'newsletter_text',
        'newsletter_button_label',
        'privacy_url',
        'terms_url',
        'copyright_text',
    ];
}
