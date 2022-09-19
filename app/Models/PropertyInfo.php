<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PropertyInfo extends Model
{
    protected $table = 'property_info';

    protected $fillable = [
        'id',
        'property_id',
        'user_indication_id',
        'contract',
        'standard',
        'location_lat',
        'location_lng'
    ];

    public function property(): HasOne
    {
        return $this->hasOne(Property::class, 'ID', 'property_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'ID', 'user_indication_id');
    }
}
