<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyInfo extends Model
{
    protected $table = 'property_info';

    protected $fillable = [
        'id',
        'property_id',
        'user_indication_id',
        'contract'
    ];

    public $timestamps = false;
}
