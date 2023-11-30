<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artists extends Model
{
    use HasFactory;

    protected $fillable = [
        'stagename', 'name', 'lastname', 'birthday', 'instagram', 'instagram', 'twitter', 'tiktok', 'youtube', 'spotify',
        'applemusic', 'amazonmusic', 'tidal', 'web', 'extraprofile', 'notes', 'agency_id'
    ];
}
