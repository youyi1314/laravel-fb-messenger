<?php

namespace Casperlaitw\LaravelFbMessenger;

use Casperlaitw\LaravelFbMessenger\Commands\GetStartButtonCommand;
use Casperlaitw\LaravelFbMessenger\Commands\GreetingTextCommand;
use Casperlaitw\LaravelFbMessenger\Commands\PersistentMenuCommand;
use Casperlaitw\LaravelFbMessenger\Providers\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelFbMessengerServiceProvider
 * @package Casperlaitw\LaravelFbMessenger
 */
class LaravelFbMessengerServiceProvider extends ServiceProvider
{
    /**
     * Config path
     * @var string
     */
    protected $configPath = __DIR__ . '/../config/fb-messenger.php';

    /**
     * Perform post-registration booting of services.
     *
     */
    public function boot()
    {
        $this->publishes([
            $this->configPath => $this->app->configPath().'/fb-messenger.php',
        ], 'config');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-fb-messenger');
        $this->publishes([__DIR__.'/../public' => $this->app->basePath().'/public/vendor'], 'public');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath, 'fb-messenger');
        $this->app->register(RouteServiceProvider::class);
        $this->app->singleton(Debug::class, Debug::class);
        $this->registerCommands();
    }

    /**
     * Register commands
     */
    private function registerCommands()
    {
        $this->commands([
            GreetingTextCommand::class,
            GetStartButtonCommand::class,
            PersistentMenuCommand::class,
        ]);
    }
}