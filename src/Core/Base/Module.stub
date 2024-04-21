<?php

namespace Core\Base\Traits\ServiceProvider;

use Illuminate\Support\Str;

trait Module
{
    /**
     * register the service provider for the module
     *
     * @param boolean $is_plugins
     */
    private function registerModules($is_plugins = false)
    {
        // the core modules
        $root_namespace = 'Core';
        $root_path = config('laragine.root_dir');

        // the plugins modules
        if ($is_plugins) {
            $root_namespace = 'Plugins';
            $root_path = config('laragine.plugins_dir');
        }

        $this->registerModuleServiceProvider($root_namespace, $root_path);
    }

    /**
     * handle registering the module service provider
     *
     * @param string $root_namespace
     * @param string $root_path
     * @param string $excluded_directory
     */
    private function registerModuleServiceProvider($root_namespace, $root_path, $excluded_directory = 'Base') 
    {
        $root_namespace_lower_case = Str::lower($root_namespace);
        foreach (glob($root_path.'/*/ModuleServiceProvider.php') as $file) {
            if (!preg_match("/{$root_namespace_lower_case}\/{$excluded_directory}/i", $file)) {
                $namespace = str_replace('/', '\\', str_replace('.php', '', $file));
                $namespace = explode("{$root_namespace_lower_case}\\", $namespace)[1];
                $this->app->register($root_namespace . '\\' . $namespace);
            }
        }
    }
}
