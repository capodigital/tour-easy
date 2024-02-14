<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suppliers extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'agency_id',
        'tradename',
        'email',
        'address',
        'notes',
        'extra_phone',
        'phone',
        'email',
        'manager',
        'manager_contact',
        'manager_email',
        'contact',
        'contact_phone',
        'contact_email',
        'city_id',
        'paydata',
        'taxname',
        'taxcode'
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agencies::class, 'agency_id');
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }

    public function socialmedias(): MorphMany
    {
        return $this->morphMany(Socialmedias::class, 'socialmediasable', 'socialmediaable_type', 'socialmediaable_id');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Documents::class, 'documentsable', 'documentable_type', 'documentable_id');
    }

    public function itineraries(): HasMany
    {
        return $this->hasMany(Itineraries::class, 'supplier_id');
    }
}
