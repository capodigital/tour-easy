<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Countries extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


    public function cities(): HasMany
    {
        return $this->hasMany(Cities::class,'country_id','code');
    }

    public function persons(): HasMany
    {
        return $this->hasMany(Persons::class,'country_id');
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tours::class, 'countrytours', 'country_id', 'tour_id')->withTimestamps();
    }
}
