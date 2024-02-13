<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Groups extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'agency_id'];

    public function persons(): HasMany
    {
        return $this->hasMany(Persons::class,'group_id');
    }
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agencies::class, 'agency_id');
    }
}
