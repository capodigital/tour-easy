<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Typecontacts extends Model
{
    use HasFactory;
    protected $fillable = [
        'description'
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contacts::class,'typecontact_id');
    }
}