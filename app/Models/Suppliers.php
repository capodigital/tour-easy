<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Suppliers extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name', 'supplier_name', 'tax_code', 'address', 'notes', 'extra_phone', 'agency_id', 'phone',
        'email', 'contact_manager', 'contact_phone', 'contact_email', 'city_id'
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agencies::class, 'agency_id');
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }
    
    public function socialmedias(): MorphMany
    {
        return $this->morphMany(Socialmedias::class, 'socialmediasable','socialmediaable_type','socialmediaable_id');
    }
}
