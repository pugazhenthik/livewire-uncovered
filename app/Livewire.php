<?php

namespace App;

use Illuminate\Support\Collection;
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

    public function fromSnapshot($snapshot)
    {
        $class = $snapshot['class'];
        $data = $snapshot['data'];
        $meta = $snapshot['meta'];

        $component = new $class;

        $properties = $this->hydrateProperties($data, $meta);

        $this->setProperties($component, $properties);

        return $component;
    }

    public function hydrateProperties($data, $meta)
    {
        $properties = [];

        foreach ($data as $key => $value) {
            if (isset($meta[$key]) && $meta[$key] == 'collection') {
                $value = collect($value);
            }
            $properties[$key] = $value;
        }

        return $properties;
    }

    public function toSnapshot($component)
    {
        $html = Blade::render(
            $component->render(),
            $properties = $this->getProperties($component)
        );

        [$data, $meta] = $this->dehydrateProperties($properties);

        $snapshot = [
            'class' => get_class($component),
            'data' => $data,
            'meta' => $meta
        ];

        return [$snapshot, $html];
    }

    public function dehydrateProperties($properties)
    {
        $meta = $data = [];

        foreach ($properties as $key => $value) {
            if ($value instanceof Collection) {
                $value = $value->toArray();
                $meta[$key] = 'collection';
            }
            $data[$key] = $value;
        }

        return [$data, $meta];
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
