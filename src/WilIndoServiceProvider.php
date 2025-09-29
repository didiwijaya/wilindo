<?php
 
namespace DidiWijaya\WilIndo;

use Illuminate\Support\ServiceProvider;
use DidiWijaya\WilIndo\WilIndoPublishCommand;

/**
 * WilIndo Service Provider
 */
class WilIndoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                WilIndoPublishCommand::class,
            ]);
            
            $this->publishes([
                __DIR__.'/config/wilindo.php' => config_path('wilindo.php'),
            ], 'wilindo-config');
            
            $this->publishes([
                __DIR__.'/database/migrations/' => database_path('migrations'),
            ], 'wilindo-migrations');
            
            $this->publishes([
                __DIR__.'/database/seeders/' => database_path('seeders'),
            ], 'wilindo-seeders');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/wilindo.php', 'wilindo'
        );
        
        // Register models for auto-discovery
        $this->app->bind('DidiWijaya\WilIndo\Models\Province');
        $this->app->bind('DidiWijaya\WilIndo\Models\City');
        $this->app->bind('DidiWijaya\WilIndo\Models\District');
        $this->app->bind('DidiWijaya\WilIndo\Models\Village');
    }
}