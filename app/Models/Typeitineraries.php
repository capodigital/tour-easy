<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Typeitineraries extends Model
{
    use HasFactory;
    protected $fillable = [
        'description'
    ];

    public function itineraries(): HasMany
    {
        return $this->hasMany(Itineraries::class,'typeitinerary_id');
    }
}
