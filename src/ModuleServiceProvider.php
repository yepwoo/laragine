<?php

namespace Yepwoo\Laragine;

use Illuminate\Support\ServiceProvider;
use Yepwoo\Laragine\Commands\MakeUnit;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'laragine');
        // $this->app->register('Core\\Base\\ModuleServiceProvider');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            /**
             * @todo load the commands dynamically
             */
            $this->commands([
                Commands\Install::class,
                Commands\MakeModule::class,
                MakeUnit::class
            ]);
        }
    }
}
