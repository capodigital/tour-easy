<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
