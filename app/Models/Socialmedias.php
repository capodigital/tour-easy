<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Socialmedias extends Model
{
    use HasFactory;
    protected $fillable = [
        'description', 'typeredes_id', 'socialmediaable_id', 'socialmediaable_type','url'
    ];

    public function socialmediasable(): MorphTo
    {
        return $this->morphTo();
    }
}
