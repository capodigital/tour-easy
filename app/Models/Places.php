<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Places extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'google_id', 'phone', 'extra_phone', 'manager',
        'email', 'gis', 'notes', 'address', 'typeplace_id', 'city_id', 'agency_id'
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agencies::class, 'agency_id');
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }
    public function typeplace(): BelongsTo
    {
        return $this->belongsTo(Typeplaces::class, 'typeplace_id');
    }
    
}
