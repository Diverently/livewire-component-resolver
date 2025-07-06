<?php

namespace Diverently\LivewireComponentResolver;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireComponentResolverServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerConfig();
        $this->registerResolver();
    }

    public function boot()
    {
        $this->bootPublishing();
        $this->bootResolver();
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/livewire-component-resolver.php', 'livewire-component-resolver');
    }

    private function registerResolver(): void
    {
        $this->app->singleton('livewire.class_namespaces', function ($app) {
            return $app['config']['livewire-component-resolver']['class_namespaces'];
        });
    }

    private function bootPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/livewire-component-resolver.php' => $this->app->configPath('livewire-component-resolver.php'),
            ], 'livewire-component-resolver');
        }
    }

    private function bootResolver(): void
    {
        Livewire::resolveMissingComponent(LivewireComponentResolver::resolve(...));
    }
}
