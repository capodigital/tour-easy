<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Documents extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'document_path', 'documentable_id', 'documentable_type','url', 'size', 'ext'
    ];

    public function documentsable(): MorphTo
    {
        return $this->morphTo();
    }

}
