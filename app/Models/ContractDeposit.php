<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractDeposit extends Model
{
    protected $table = 'contract_deposits';

    protected $fillable = [
        'id',
        'bank',
        'agency',
        'account',
        'responsible',
        'responsible_cpf',
        'pix'
    ];
}
