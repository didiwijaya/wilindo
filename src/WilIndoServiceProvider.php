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
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}