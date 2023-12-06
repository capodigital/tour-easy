<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contacts extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'lastname', 'birthday', 'notes', 'extra_phone', 'agency_id', 'phone',
        'email', 'lang', 'position', 'notify', 'typecontact_id', 'city_id'
    ];
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agencies::class, 'agency_id');
    }
    public function typecontact(): BelongsTo
    {
        return $this->belongsTo(Typecontacts::class, 'typecontact_id');
    }
    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tours::class, 'tourcontacts', 'contact_id', 'tour_id')->withTimestamps();
    }
    
}
