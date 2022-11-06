<?php

namespace App\Http\Livewire;

use App\Models\Client as ModelClient;
use Livewire\Component;

class Client extends Component
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
        $clients = ModelClient::query()
            ->where('name', 'like', "%$this->name%")
            ->where('cpf', 'like', "%$this->cpf%")
            ->where('status', 'like', "%$this->status%")
            ->get();

        return view('livewire.client', [
            'clients' => $clients
        ]);
    }
}
