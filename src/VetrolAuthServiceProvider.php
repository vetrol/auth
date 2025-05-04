<?php

namespace Vetrol\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Vetrol\Auth\Drivers\VetrolAuthProvider;

class VetrolAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoutes();
        $this->registerMigrations();
        $this->registerPublishing();
        $this->registerAuthUserProvider();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/vetrol-auth.php', 'vetrol-auth');
    }

    private function registerRoutes()
    {
        if (VetrolAuth::$registersRoutes) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }
    }

    private function registerMigrations()
    {
        if (VetrolAuth::$runsMigrations && $this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_user_email_addresses_table.php' => database_path('migrations/'.date('Y-m-d_His').'_create_user_email_addresses_table.php'),
            ], 'migrations');

            $this->publishes([
                __DIR__ . '/../config/vetrol-auth.php' => config_path('vetrol-auth.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../routes/web.php' => config_path('../routes/vetrol-auth.php'),
            ], 'routes');
        }
    }

    protected function registerServiceProvider(): void
    {
        if (VetrolAuth::$registersServiceProviders) {
            $this->app->register(VetrolAuthEventServiceProvider::class);
        }
    }

    protected function registerAuthUserProvider(): void
    {
        Auth::provider('VetrolAuth', static function ($app, array $config) {
            return new VetrolAuthProvider($app->get('hash'), $config['model']);
        });
    }
}
