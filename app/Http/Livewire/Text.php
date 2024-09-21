<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Text extends Component
{

    public $count = 0;
 
    public function increment()
    {
        $this->count++;
    }
    public function render()
    {
        return view('livewire.text');
    }
}
