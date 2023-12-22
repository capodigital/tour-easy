<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Agencies extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'tradename', 'taxname', 'taxcode', 'owner', 'address', 'email', 'notes', 'phone',
        'city_id', 'password', 'typeagency_id'
    ];
    protected $hidden = [
        'password',
    ];


    protected $casts = [
        'password' => 'hashed',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }
    public function typeagency(): BelongsTo
    {
        return $this->belongsTo(Typeagencies::class, 'typeagency_id');
    }

    public function artists(): HasMany
    {
        return $this->hasMany(Artists::class, 'agency_id');
    }
    public function tours(): HasMany
    {
        return $this->hasMany(Tours::class, 'agency_id');
    }
    public function socialmedias(): MorphMany
    {
        return $this->morphMany(Socialmedias::class, 'socialmediasable', 'socialmediaable_type', 'socialmediaable_id');
    }
    public function documents(): MorphMany
    {
        return $this->morphMany(Documents::class, 'documentsable', 'documentable_type', 'documentable_id');
    }
    public function contacts(): HasMany
    {
        return $this->hasMany(Contacts::class, 'agency_id');
    }
    public function suppliers(): HasMany
    {
        return $this->hasMany(Suppliers::class, 'agency_id');
    }
    public function places(): HasMany
    {
        return $this->hasMany(Places::class, 'agency_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'agency_id');
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['socialmedias'] = $this->socialmedias;
        return $data;
    }
    public function toArray1()
    {
        $data = parent::toArray();
        $data['documents'] = $this->documents;
        return $data;
    }
}
