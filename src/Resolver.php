<?php

namespace Diverently\LivewireComponentResolver;

use Livewire\Exceptions\ComponentNotFoundException;

class Resolver
{
    public static function register(string $alias, string $namespace): void
    {
        $namespaces = app('livewire.class_namespaces');

        $namespaces[$alias] = $namespace;

        app()->instance('livewire.class_namespaces', $namespaces);
    }

    public static function resolve($name)
    {
        if (! is_string($name)) {
            return null;
        }

        $namespaces = app('livewire.class_namespaces');

        $separator = config('livewire-component-resolver.namespace_separator');

        // Handle namespaced components like: foo::some-component or foo::nested.some-component
        if (str_contains($name, $separator)) {
            [$componentNamespace, $componentName] = explode($separator, $name, 2);

            if (! array_key_exists($componentNamespace, $namespaces)) {
                throw new ComponentNotFoundException("Unable to find component \"$name\": Unknown namespace");
            }

            $class = self::generateClassFromName($componentName, $namespaces[$componentNamespace]);
        } else {
            $class = self::generateClassFromName($name);
        }

        // If class can't be found, see if there is an index component in a subfolder...
        if (! class_exists($class)) {
            $class = $class . '\\Index';
        }

        if (! class_exists($class)) {
            return null;
        }

        return $class;
    }

    // This method adapted from Livewire\Mechanisms\ComponentRegistry to support variable root namespaces
    protected static function generateClassFromName($name, $rootNamespace = null)
    {
        $class = collect(str($name)->explode('.'))
            ->map(fn($segment) => (string) str($segment)->studly())
            ->join('\\');

        if (empty($rootNamespace)) {
            return $class;
        }

        return $rootNamespace . '\\' . $class;
    }
}
