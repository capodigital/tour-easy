<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agencies extends Model
{
    use HasFactory;
    protected $fillable = [
        'tradename', 'taxname', 'taxcode', 'owner', 'address', 'email', 'web', 'notes', 'phone',
        'city_id'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }

    public function artists(): HasMany
    {
        return $this->hasMany(Artists::class,'agency_id');
    }
}
