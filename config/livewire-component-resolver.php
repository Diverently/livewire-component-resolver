<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Namespace Separator
    |--------------------------------------------------------------------------
    |
    | This string is used to separate the namespace alias from the component name
    | when referencing Livewire components. For example, with the default value
    | '::', you can reference a component as 'blog::post.show', where 'blog' is
    | the namespace alias and 'post.show' is the component name.
    |
    */

    'namespace_separator' => '::',

    /*
    |--------------------------------------------------------------------------
    | Class Namespaces
    |--------------------------------------------------------------------------
    |
    | Here you may define a mapping of namespace aliases to their corresponding
    | root class namespaces. The alias is used in your Blade views to reference
    | components, and the value should be the PHP namespace where those
    | components are located. For example:
    |
    | 'blog' => 'Modules\\Blog\\Livewire'
    |
    | This allows you to reference a component as <livewire:blog::post.show />.
    |
    */

    'class_namespaces' => [
        // 'blog' => 'Modules\\Blog\\Livewire',
    ]
];
