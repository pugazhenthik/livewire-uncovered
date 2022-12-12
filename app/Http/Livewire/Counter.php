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
        <div class="flex items-center border border-4 border-gray-900 rounded-full px-16 py-12 text-[96px]">
            <span>
            {{ $count }}
            </span>
            <button wire:click="increment" class="p-0 ml-4 text-[48px] font-bold">+
            </button>
        </div>
        HTML;
    }
}
