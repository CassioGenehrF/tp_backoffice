<?php

namespace App\Models;

use App\Models\Commitment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RentalInformation extends Model
{
    protected $table = 'backoffice_rental_information';
    
    protected $fillable = [
        'id',
        'user_id',
        'commitment_id',
        'guest_name',
        'guest_phone',
        'price',
        'adults',
        'kids',
        'contract'
    ];

    public $timestamps = false;

    public function commitment(): HasOne
    {
        return $this->hasOne(Commitment::class, 'id', 'commitment_id');
    }
}
