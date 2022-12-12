<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <button
                    wire:click="increment"
                    class="px-4 py-2 mx-4 bg-slate-500 text-gray-100 text-xl font-bold"
                >
                    +
                </button>   
                <span>
                {{ $count }}
                </span>
        </div>
        HTML;
    }
}
