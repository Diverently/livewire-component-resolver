# Livewire Component Resolver

A Laravel package to resolve [Livewire](https://livewire.laravel.com/) components from multiple namespaces, making it easy to organize and discover components across your application or modules.

> **Works great with [nWidart/laravel-modules](https://github.com/nWidart/laravel-modules)!**

---

## Features & Motivation

By default, Livewire only supports a single namespace (`App\Livewire`) for all components. This means all your Livewire components must reside in that one namespace, which can become limiting as your application grows or when working with modular architectures.

### ⚡️ Performance

Unlike other similar packages, **Livewire Component Resolver resolves components dynamically in microseconds**. Other packages often spend significant time during application bootstrapping combing through your files to discover all components, which can seriously hurt your application's performance - especially in large projects.

**With this package, there is no file system scanning or boot-time discovery. Components are resolved on demand, only when needed, resulting in blazing fast performance.**

---

## What You Get

- Register custom namespaces for your Livewire components.
- Resolve components using a namespace separator (e.g., `foo::some-component`).
- Enjoy microsecond-fast, dynamic component resolution.
- No slow bootstrapping or file scanning to find all components.

## Installation

```bash
composer require diverently/livewire-component-resolver
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=livewire-component-resolver
```

This will create a `config/livewire-component-resolver.php` file where you can define your component namespaces and separator.

Example config:

```php
return [
    // String used to separate the namespace from the component name e.g. `blog::post.show`
    'namespace_separator' => '::',

    // Map of namespace aliases to root class namespaces.
    'class_namespaces' => [
        'blog' => 'Modules\\Blog\\Livewire',
    ],
];
```

## Usage

### Registering a Namespace

You can register a namespace for your Livewire components either through the config (see above) or at runtime:

```php
use Diverently\LivewireComponentResolver\Resolver;

Resolver::register('blog', 'Modules\\Blog\\Livewire');
```

Then you can reference components like `blog::post.show` in your views.

### Resolving Components

When Livewire cannot find a component, this resolver will attempt to resolve it using the registered namespaces and aliases.

For example, if you have a component at `Modules/Blog/Livewire/Post/Show.php`, you can use:

```blade
<livewire:blog::post.show />
```

## Integration with [nWidart/laravel-modules](https://github.com/nWidart/laravel-modules)

This package is designed to work seamlessly with [nWidart/laravel-modules](https://github.com/nWidart/laravel-modules). You can easily register each module's Livewire namespace and use modular component aliases in your Blade views.

### Example 1: Registering Modules via the Config File

You can add all your module namespaces in the `config/livewire-component-resolver.php` file:

```php
return [
    'namespace_separator' => '::',
    'class_namespaces' => [
        'blog' => 'Modules\\Blog\\Livewire',
        'shop' => 'Modules\\Shop\\Livewire',
        // Add more modules as needed
    ],
];
```

### Example 2: Registering in Each Module's Service Provider

A more dynamic option would be to register the namespace in each module's service provider, for example in `Modules/Blog/Providers/BlogServiceProvider.php`:

```php
use Diverently\LivewireComponentResolver\Resolver;

public function boot()
{
    Resolver::register($this->moduleNameLower, 'Modules\\Blog\\Livewire');
}
```

If your module name is "Blog", `$this->moduleNameLower` would be `'blog'`, so you can reference components as:

```blade
<livewire:blog::post.show />
```

Repeat this in each module's service provider, adjusting the namespace and alias as needed.

---

## License

This package is open-sourced software licensed under the MIT license.
