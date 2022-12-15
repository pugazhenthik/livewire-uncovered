<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Laravel</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="mx-auto">
        <div class="flex items-center items-center justify-center mt-10">
            <!-- Alpine Plugins -->
            <script
                defer
                src="https://unpkg.com/@alpinejs/morph@3.x.x/dist/cdn.min.js"
            ></script>
             
            <!-- Alpine Core -->
            <script
                defer
                src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"
            ></script>
            @livewire(App\Http\Livewire\Counter::class)
        </div>
        <script src="livewire.js"></script>
    </body>
</html>
