<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Laravel</title>
        <link
            href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"
            rel="stylesheet"
        />
        <script src="https://cdn.tailwindcss.com"></script>
        @livewireStyles
    </head>
    <body class="mx-auto">
        <div class="flex items-center items-center justify-center mt-10">
            {!! livewire(App\Http\Livewire\Counter::class) !!}
        </div>
    </body>
</html>
<?php 
function livewire($class) { 
    $component = new $class; return Blade::render($component->render(),
getProperties($component)); } function getProperties($class) { $properties = [];
$reflectedProperties = (new
ReflectionClass($class))->getProperties(ReflectionProperty::IS_PUBLIC);
foreach($reflectedProperties as $property) { $properties[$property->getName()] =
$property->getValue($class); } return $properties; } ?>
