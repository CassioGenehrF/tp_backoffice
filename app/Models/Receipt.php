<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Receipt extends Model
{
    protected $table = 'backoffice_receipts';

    protected $fillable = [
        'id',
        'user_id',
        'month',
        'value',
        'reason',
        'receipt'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'ID', 'user_id');
    }
}
