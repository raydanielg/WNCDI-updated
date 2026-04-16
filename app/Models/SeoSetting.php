<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'default_meta_title',
        'default_meta_description',
        'default_meta_keywords',
        'og_image_url',
    ];
}
