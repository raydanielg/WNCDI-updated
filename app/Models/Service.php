<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'body',
        'image_url',
    ];

    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            if (! $service->slug) {
                $service->slug = Str::slug($service->title);
            }
        });
    }
}
