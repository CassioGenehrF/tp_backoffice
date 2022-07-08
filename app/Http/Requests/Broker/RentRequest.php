<?php

namespace App\Http\Requests\Broker;

use Illuminate\Foundation\Http\FormRequest;

class RentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            //
        ];
    }
}
