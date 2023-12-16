<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promotions extends Model
{
    use HasFactory;
    protected $fillable = [
        'platform', 'notes', 'itinerary_id', 'tour_id'
    ];

    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(Agencies::class, 'itinerary_id');
    }
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Cities::class, 'tour_id');
    }
}
