<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Added this line
use Illuminate\Database\Eloquent\SoftDeletes; // Added this line

class Event extends Model
{
    use HasFactory, SoftDeletes; // Modified this line

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
        'google_map_embed',
        'seo_title',
        'seo_description',
        'organizer_name',
        'organizer_logo_path',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function scanners()
    {
        return $this->belongsToMany(User::class, 'event_scanner', 'event_id', 'user_id')->withTimestamps();
    }
}
