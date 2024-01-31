<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Countries extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


    public function cities(): HasMany
    {
        return $this->hasMany(Cities::class,'country_id','code');
    }

    public function persons(): HasMany
    {
        return $this->hasMany(Persons::class,'country_id');
    }
}
