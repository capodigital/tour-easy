<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artists extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'stagename', 'name', 'lastname', 'birthday', 'notes', 'tags', 'agency_id', 'image',
        'email', 'password'
    ];
    protected $hidden = [
        'password',
    ];

   
    protected $casts = [
        'password' => 'hashed',
    ];


    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agencies::class, 'agency_id');
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tours::class,'artist_id');
    }

    public function socialmedias(): MorphMany
    {
        return $this->morphMany(Socialmedias::class, 'socialmediasable','socialmediaable_type','socialmediaable_id');
    }
}
