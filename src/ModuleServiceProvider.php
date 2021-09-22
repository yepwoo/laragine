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
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'laragine');
        
        // instantiate the loader
        $loader = new \Yepwoo\Laragine\Helpers\Psr4AutoloaderClass;
        // register the autoloader
        $loader->register();
        // register the base directories for the namespace prefix
        $loader->addNamespace('Core', base_path().'./core');

        if (class_exists('Core\\Base\\ModuleServiceProvider')) {
            $this->app->register('Core\\Base\\ModuleServiceProvider');
        }
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
                Commands\MakeUnit::class,
            ]);
        }
    }
}
