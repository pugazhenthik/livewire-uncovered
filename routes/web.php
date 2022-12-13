<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/livewire', function () {
    return request('callMethod');
});

Blade::directive('livewire', function ($expression) {
    return "<?php echo (new App\Livewire)->initialRender({$expression}); ?>";
});
