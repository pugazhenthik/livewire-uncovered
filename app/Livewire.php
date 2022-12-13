<?php

namespace App;

use Illuminate\Support\Facades\Blade;
use ReflectionClass;
use ReflectionProperty;

class Livewire
{
    public function initialRender($class)
    {
        $component = new $class;
        $html = Blade::render(
            $component->render(),
            $this->getProperties($component)
        );
        $snapshot = [
            'class' => get_class($component),
            'data' => $this->getProperties($component)
        ];

        $renderProperties = htmlentities(json_encode($snapshot));
        return <<<HTML
            <div wire:snapshot="{$renderProperties}">
                {$html}
            </div>
        HTML;
    }

    public function getProperties($class)
    {
        $properties = [];
        $reflectedProperties = (new
            ReflectionClass($class))->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($reflectedProperties as $property) {
            $properties[$property->getName()] =
                $property->getValue($class);
        }
        return $properties;
    }
}
