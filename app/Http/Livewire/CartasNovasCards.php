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
        $this->cartas = collect();

        for ($i = 1; $i <= 7; $i++) {
            $cartasPorTipo = Carta::where('IDTipoCarta', $i)
                      ->orderBy('Prazo', 'DESC')
                      ->take(6)
                      ->get();
            $this->cartas = $this->cartas->merge($cartasPorTipo);
        }

        $this->tiposCartas = TipoCarta::all();
    }

    public function render()
    {
        return view('livewire.cartas-novas-cards');
    }
}
