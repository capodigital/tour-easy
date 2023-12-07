<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Typeplaces extends Model
{
    use HasFactory;
    protected $fillable = [
        'description'
    ];

    public function places(): HasMany
    {
        return $this->hasMany(Places::class,'typeplace_id');
    }
}
