<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VerifiedProperty extends Model
{
    protected $table = 'backoffice_verified_property';

    protected $fillable = [
        'id',
        'property_id',
        'document',
        'relation',
        'verified'
    ];

    public function property(): HasOne
    {
        return $this->hasOne(Property::class, 'ID', 'property_id');
    }
}
