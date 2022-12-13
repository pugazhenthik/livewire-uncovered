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
            @livewire(App\Http\Livewire\Counter::class)
        </div>
        <script>
            document.querySelectorAll("[wire\\:snapshot]").forEach((el) => {
                let snapshot = JSON.parse(el.getAttribute("wire:snapshot"));
                console.log(snapshot);
            });
        </script>
    </body>
</html>
