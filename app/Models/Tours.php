<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tours extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'tourname', 'startdate', 'enddate', 'tourcartel', 'agency_id', 'artist_id', 'notes'
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agencies::class, 'agency_id');
    }
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artists::class, 'artist_id');
    }
    public function socialmedias(): MorphMany
    {
        return $this->morphMany(Socialmedias::class, 'socialmediasable','socialmediaable_type','socialmediaable_id');
    }
    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contacts::class, 'tourcontacts', 'tour_id', 'contact_id')->withTimestamps();
    }
    public function itineraries(): HasMany
    {
        return $this->hasMany(Itineraries::class,'tour_id');
    }
}
