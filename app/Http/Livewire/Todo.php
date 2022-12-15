<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Todo extends Component
{
    public $todos = [
        'Todo 1',
        'Todo 2'
    ];
    public $draft = 'Todo 3';

    public function addTodo()
    {
        $this->todos[] = $this->draft;
        $this->draft = '';
    }

    public function render()
    {
        return <<<'HTML'
            <div>
                <input type="text" name="todo" class="bg-text-200 px-4 py-2 border" wire:model="draft" />
                <button class="bg-blue-300 px-4 py-2 rounded" wire:click="addTodo">Add Todo</button>
                <ul class="my-10">
                @foreach($todos as $todo)
                    <li>{{$todo}}</li>
                @endforeach
                </ul>
            </div>
        HTML;
    }
}
