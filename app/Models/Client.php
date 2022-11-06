<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'cpf',
        'phone',
        'message',
        'feedback_stars',
        'feedback_positive',
        'feedback_negative',
        'status'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'ID', 'user_id');
    }
}
