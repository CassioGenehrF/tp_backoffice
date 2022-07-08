<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Commitment extends Model
{
    protected $table = 'backoffice_commitments';
    
    protected $fillable = [
        'id',
        'user_id',
        'property_id',
        'checkin',
        'checkout',
        'type'
    ];

    public $timestamps = false;

    public function property(): HasOne
    {
        return $this->hasOne(Property::class, 'ID', 'property_id');
    }
}
