<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ContractClient extends Model
{
    use Uuids;
    protected $table = 'contract_clients';

    protected $fillable = [
        'id',
        'property_id',
        'property_address',
        'property_city',
        'property_uf',
        'owner_name',
        'owner_cpf',
        'owner_address',
        'owner_cep',
        'owner_city',
        'owner_uf',
        'owner_phone_number',
        'client_name',
        'client_cpf',
        'client_address',
        'client_cep',
        'client_city',
        'client_uf',
        'client_phone_number',
        'rented_days',
        'checkin_date',
        'checkin_hour',
        'checkin_limit_hour',
        'checkout_date',
        'checkout_hour',
        'guests_number',
        'excess_value',
        'rent_value',
        'signal_value',
        'clean_tax',
        'bail_tax',
        'allow_pet',
        'contract_deposit_id',
        'client_signature',
        'client_signature_at',
        'owner_signature',
        'owner_signature_at'
    ];

    protected $with = [
        'contractDeposit'
    ];

    public function property(): HasOne
    {
        return $this->hasOne(Property::class, 'ID', 'property_id');
    }

    public function contractDeposit(): HasOne
    {
        return $this->hasOne(ContractDeposit::class, 'id', 'contract_deposit_id');
    }
}
