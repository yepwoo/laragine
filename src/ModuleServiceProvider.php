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

        module_autoloader();
        module_autoloader('Plugins', config('laragine.plugins_dir'));

        if (class_exists('Core\\Base\\ModuleServiceProvider')) {
            /**
             * it's in try/catch block because when running the tests it tries to register
             * a class that's not found, the error is "Class 'Core\laravel\' not found"
             */
            try {
                $this->app->register('Core\\Base\\ModuleServiceProvider');
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        if (class_exists('Plugins\\Base\\ModuleServiceProvider')) {
            /**
             * it's the same error as in the previous try/catch block
             */
            try {
                $this->app->register('Plugins\\Base\\ModuleServiceProvider');
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/lang', 'laragine');

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
