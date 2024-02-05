<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persons extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name', 'lastname', 'birthday', 'notes', 'extra_phone', 'agency_id', 'phone',
        'email', 'lang', 'position', 'notify', 'typecontact_id', 'country_id', 'passport', 
        'passport_expiry', 'notify_type', 'group_id'
    ];
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agencies::class, 'agency_id');
    }
    public function group(): BelongsTo
    {
        return $this->belongsTo(Groups::class, 'group_id');
    }
    public function country(): BelongsTo
    {
        return $this->belongsTo(Cities::class, 'country_id');
    }
    public function typecontact(): BelongsTo
    {
        return $this->belongsTo(Typecontacts::class, 'typecontact_id');
    }
    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tours::class, 'tourcontacts', 'person_id', 'tour_id')->withTimestamps();
    }

    public function socialmedias(): MorphMany
    {
        return $this->morphMany(Socialmedias::class, 'socialmediasable','socialmediaable_type','socialmediaable_id');
    }
    public function documents(): MorphMany
    {
        return $this->morphMany(Documents::class, 'documentsable','documentable_type','documentable_id');
    }
    public function itineraries(): HasMany
    {
        return $this->hasMany(Itineraries::class,'person_id');
    }

    public function toArray() {
        $data = parent::toArray();
        $data['socialmedias'] = $this->socialmedias;
        return $data;
    }
    public function toArray1() {
        $data = parent::toArray();
        $data['documents'] = $this->documents;
        return $data;
    }
    
}
