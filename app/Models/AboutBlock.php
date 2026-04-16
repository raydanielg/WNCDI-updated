<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_label',
        'title_line1',
        'title_line2',
        'intro_text',
        'bullet1',
        'bullet2',
        'bullet3',
        'cta_label',
        'cta_url',
        'left_image_url',
        'right_image_url',
        'experience_label',
        'experience_text',
    ];
}
