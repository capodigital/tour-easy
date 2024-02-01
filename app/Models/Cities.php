<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cities extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'country_id'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function agencies(): HasMany
    {
        return $this->hasMany(Agencies::class,'city_id');
    }
    public function places(): HasMany
    {
        return $this->hasMany(Places::class,'city_id');
    }
    
    public function suppliers(): HasMany
    {
        return $this->hasMany(Suppliers::class,'city_id');
    }
}
