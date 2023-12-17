<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photos extends Model
{
    use HasFactory;
    protected $fillable = [
        'url', 'tour_id'
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Cities::class, 'tour_id');
    }
}
