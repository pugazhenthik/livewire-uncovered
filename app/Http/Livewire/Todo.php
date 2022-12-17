<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Todo extends Component
{
    public $todos;
    public $draft;

    public function mount()
    {
        $this->todos = collect([
            'Learning livewire',
            'Learning laravel'
        ]);
    }

    public function addTodo()
    {
        $this->todos->push($this->draft);
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

    public function updateDraft()
    {
        $this->draft = strtoupper($this->draft);
    }
}
