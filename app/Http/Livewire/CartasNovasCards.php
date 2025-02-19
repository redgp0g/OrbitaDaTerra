<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Carta;
use App\Models\TipoCarta;

class CartasNovasCards extends Component
{
    public $cartas;
    public $cadastro;
    public $tiposCartas;
    public $vendedor;


    public function mount($cadastro, $vendedor)
    {
        $this->cadastro = $cadastro;
        $this->vendedor = $vendedor;
        $this->cartas = Carta::with('TipoCarta')->orderBy('Prazo', 'DESC')->get();
        $this->tiposCartas = TipoCarta::all();
    }

    public function render()
    {
        return view('livewire.cartas-novas-cards');
    }
}
