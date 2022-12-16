<?php

namespace App;

use ReflectionClass;
use ReflectionProperty;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;

class Livewire
{
    public function initialRender($class)
    {
        $component = new $class;

        if (method_exists($component, 'mount')) {
            $component->mount();
        }

        [$snapshot, $html] = $this->toSnapshot($component);

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

    public function fromSnapshot($snapshot)
    {
        $class = $snapshot['class'];
        $data = $snapshot['data'];

        $component = new $class;

        $this->setProperties($component, $data);

        return $component;
    }

    public function toSnapshot($component)
    {
        $html = Blade::render(
            $component->render(),
            $this->getProperties($component)
        );

        $snapshot = [
            'class' => get_class($component),
            'data' => $this->getProperties($component)
        ];

        return [$snapshot, $html];
    }

    public function setProperties($component, $properties)
    {
        foreach ($properties as $key => $value) {
            $component->{$key} = $value;
        }
        return $component;
    }

    public function callMethod($component, $method)
    {
        $component->{$method}();
    }

    public function updateProperty($component, $property, $value)
    {
        $component->{$property} = $value;

        $updatedMethod = 'update' . Str::title($property);

        if (method_exists($component, $updatedMethod)) {
            $component->{$updatedMethod}();
        }
    }
}
