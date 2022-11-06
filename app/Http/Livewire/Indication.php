<?php

namespace App\Http\Livewire;

use App\Models\Indication as ModelIndication;
use Livewire\Component;

class Indication extends Component
{
    public $name;
    public $cpf;
    public $status;

    protected $queryString = [
        'name',
        'cpf',
        'status'
    ];

    public function render()
    {
        $indications = ModelIndication::query()
            ->where('name', 'like', "%$this->name%")
            ->where('cpf', 'like', "%$this->cpf%")
            ->where('status', 'like', "%$this->status%")
            ->get();

        return view('livewire.indication', [
            'indications' => $indications
        ]);
    }
}
