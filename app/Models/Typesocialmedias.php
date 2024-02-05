<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Typesocialmedias extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'logo', 'url'
    ];

    public function socialmedias(): HasMany
    {
        return $this->hasMany(Socialmedias::class,'typesocialmedia_id');
    }
}
