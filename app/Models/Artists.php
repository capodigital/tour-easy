<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artists extends Model
{
    use HasFactory;

    protected $fillable = [
        'stagename', 'name', 'lastname', 'birthday', 'instagram', 'facebook', 'twitter', 'tiktok', 'youtube', 'spotify',
        'applemusic', 'amazonmusic', 'tidal', 'web', 'extraprofile', 'notes', 'tags', 'agency_id'
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agencies::class, 'agency_id');
    }
}
