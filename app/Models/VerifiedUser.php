<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VerifiedUser extends Model
{
    protected $table = 'backoffice_verified_user';

    protected $fillable = [
        'id',
        'user_id',
        'document',
        'confirmation',
        'code',
        'verified'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'ID', 'user_id');
    }
}
