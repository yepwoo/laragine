<?php

namespace Yepwoo\Laragine;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('Core\\Base\\ModuleServiceProvider');
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
                \Yepwoo\Laragine\Commands\Install::class,
            ]);
        }
    }
}
