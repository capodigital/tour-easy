<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourContact extends Model
{
    use HasFactory;
    protected $fillable = [
        'tour_id',
        'person_id'
    ];

    public $table = 'personcontacts';
}
