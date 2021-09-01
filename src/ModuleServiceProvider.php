<?php

namespace Yepwoo\Laragine;

use Illuminate\Support\ServiceProvider;
use Yepwoo\Laragine\Traits\ServiceProvider\File;
use Yepwoo\Laragine\Traits\ServiceProvider\Module;

class ModuleServiceProvider extends ServiceProvider
{
    use File, Module;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadFiles(__DIR__);
        $this->registerModules();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
