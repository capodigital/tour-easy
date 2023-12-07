<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Typeagencies extends Model
{
    use HasFactory;
    protected $fillable = [
        'description'
    ];

    public function agencies(): HasMany
    {
        return $this->hasMany(Agencies::class,'typeagency_id');
    }
}
