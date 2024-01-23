<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Itineraries extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'startdate', 'enddate', 'notes', 'outoflour', 'carrier', 'carrier_id', 'showcheck',
        'showtime', 'notify', 'tour_id', 'typeitinerary_id', 'place_id', 'city_start_id',
        'city_destination_id', 'person_id', 'supplier_id'
    ];

    public function cityStart(): BelongsTo
    {
        return $this->belongsTo(Cities::class, 'city_start_id');
    }
    public function cityEnd(): BelongsTo
    {
        return $this->belongsTo(Cities::class, 'city_destination_id');
    }
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tours::class, 'tour_id');
    }
    public function typeitinerary(): BelongsTo
    {
        return $this->belongsTo(Typeitineraries::class, 'typeitinerary_id');
    }
    public function place(): BelongsTo
    {
        return $this->belongsTo(Places::class, 'place_id');
    }
    public function person(): BelongsTo
    {
        return $this->belongsTo(Persons::class, 'person_id');
    }
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }
    public function tickets(): HasMany
    {
        return $this->hasMany(Tickets::class,'itinerary_id');
    }
    
    
}
