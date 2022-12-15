<?php

use App\Livewire;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/livewire', function () {
    $livewire = new Livewire;
    $component = $livewire->fromSnapshot(request('snapshot'));

    if ($method = request('callMethod')) {
        $livewire->callMethod($component, $method);
    }

    if ([$property, $value] = request('updateProperty')) {
        $livewire->updateProperty($component, $property, $value);
    }

    [$snapshot, $html] = $livewire->toSnapshot($component);

    return [
        'snapshot' => $snapshot,
        'html' => $html
    ];
});

Blade::directive('livewire', function ($expression) {
    return "<?php echo (new App\Livewire)->initialRender({$expression}); ?>";
});
