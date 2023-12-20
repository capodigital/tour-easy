<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tickets extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'lastname', 'amount', 'wallet', 'notes', 'chain', 'itinerary_id',
        'email'
    ];
    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(Itineraries::class, 'itinerary_id');
    }
}
