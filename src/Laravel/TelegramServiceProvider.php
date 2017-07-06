<?php

namespace Telegram\Bot\Laravel;

use Laracasts\Generators\Commands\MakeTelegramCommand;
use Telegram\Bot\Api;
use Telegram\Bot\BotsManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container as Application;
use Illuminate\Foundation\Application as LaravelApplication;

/**
 * Class TelegramServiceProvider.
 */
class TelegramServiceProvider extends ServiceProvider
{
    /**
     * List of artisan commands
     * @var array
     */
    protected $commands = [
        MakeTelegramCommand::class,
    ];

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig($this->app);
    }

    /**
     * Setup the config.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     *
     * @return void
     */
    protected function setupConfig(Application $app)
    {
        $source = __DIR__.'/config/telegram.php';

        if ($app instanceof LaravelApplication && $app->runningInConsole()) {
            $this->publishes([$source => config_path('telegram.php')]);
        } elseif ($app instanceof LumenApplication) {
            $app->configure('telegram');
        }

        $this->mergeConfigFrom($source, 'telegram');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerManager($this->app);
        $this->registerBindings($this->app);
        $this->commands($this->commands);
    }

    /**
     * Register the manager class.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     *
     * @return void
     */
    protected function registerManager(Application $app)
    {
        $app->singleton('telegram', function ($app) {
            $config = (array)$app['config']['telegram'];

            return (new BotsManager($config))->setContainer($app);
        });

        $app->alias('telegram', BotsManager::class);
    }

    /**
     * Register the bindings.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     *
     * @return void
     */
    protected function registerBindings(Application $app)
    {
        $app->bind('telegram.bot', function ($app) {
            $manager = $app['telegram'];

            return $manager->bot();
        });

        $app->alias('telegram.bot', Api::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['telegram', 'telegram.bot', BotsManager::class, Api::class];
    }
}
