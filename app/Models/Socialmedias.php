<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Socialmedias extends Model
{
    use HasFactory;
    protected $fillable = [
        'description', 'typesocialmedia_id', 'socialmediaable_id', 'socialmediaable_type','url'
    ];

    public function socialmediasable(): MorphTo
    {
        return $this->morphTo();
    }

    public function typesocialmedia(): BelongsTo
    {
        return $this->belongsTo(Typesocialmedias::class, 'typesocialmedia_id');
    }

    public function toArray() {
        $data = parent::toArray();
        $data['typered'] = $this->typered;
        return $data;
    }
}
