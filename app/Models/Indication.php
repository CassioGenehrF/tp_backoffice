<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Indication extends Model
{
    protected $table = 'indications';

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'cpf',
        'email',
        'phone',
        'status',
        'value',
        'rented_month'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'ID', 'user_id');
    }
}
