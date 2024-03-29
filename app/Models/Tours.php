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
        'tourname', 'startdate', 'enddate', 'tourcartel', 'agency_id', 'artist_id', 'notes',
        'spotify_list', 'youtube_list', 'active'
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
    public function documents(): MorphMany
    {
        return $this->morphMany(Documents::class, 'documentsable','documentable_type','documentable_id');
    }
    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Persons::class, 'persontours', 'tour_id', 'person_id')->withTimestamps();
    }
    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Countries::class, 'countrytours', 'tour_id', 'country_id')->withTimestamps();
    }
    public function itineraries(): HasMany
    {
        return $this->hasMany(Itineraries::class,'tour_id');
    }
    public function photos(): HasMany
    {
        return $this->hasMany(Photos::class,'tour_id');
    }

    public function toArray() {
        $data = parent::toArray();
        $data['artist'] = $this->artist;
        return $data;
    }
    public function toArray1() {
        $data = parent::toArray();
        $data['documents'] = $this->documents;
        return $data;
    }
}
