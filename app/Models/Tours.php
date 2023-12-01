<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tours extends Model
{
    use HasFactory;
    protected $fillable = [
        'tourname', 'startdate', 'enddate', 'tourcartel', 'agency_id', 'artist_id', 'web'
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agencies::class, 'agency_id');
    }
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artists::class, 'artist_id');
    }
}
