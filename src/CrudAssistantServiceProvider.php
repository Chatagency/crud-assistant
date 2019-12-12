<?php

namespace Chatagency\CrudAssistant;

use Illuminate\Support\ServiceProvider;

/**
 * @codeCoverageIgnore
 */
class CrudAssistantServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('crud-assistant.php'),
        ], 'crud-assistant');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'crud-assistant');
    }
}
