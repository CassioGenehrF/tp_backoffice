<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ContractClient extends Model
{
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
        'allow_pet'
    ];

    public function property(): HasOne
    {
        return $this->hasOne(Property::class, 'ID', 'property_id');
    }
}