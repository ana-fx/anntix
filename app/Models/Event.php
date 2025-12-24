<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'status',
        'banner_path',
        'thumbnail_path',
        'start_date',
        'end_date',
        'description',
        'terms',
        'location',
        'province',
        'city',
        'zip',
        'latitude',
        'longitude',
        'seo_title',
        'seo_description',
        'organizer_name',
        'organizer_photo_path',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}
