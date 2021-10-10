<?php

namespace Core\Base\Traits\ServiceProvider;

trait File
{
    /**
     * load the module files (ex:views, migrations ...etc)
     *
     * @param string $dir
     * @param string $module
     * @param boolean $is_core
     */
    protected function loadFiles($dir, $module = 'base', $is_core = true)
    {
        $module_root_dir = $is_core ? 'core' : 'plugins';

        $this->loadRoutesFrom($dir . '/routes/web.php');
        $this->loadRoutesFrom($dir . '/routes/api.php');
        $this->loadMigrationsFrom($dir . '/Database/Migrations');
        $this->loadViewsFrom($dir . '/views', "{$module_root_dir}#{$module}");
        $this->mergeConfigFrom($dir . '/config/main.php', "{$module_root_dir}_{$module}");
        $this->publishes([
            $dir . '/views' => resource_path("views/vendor/{$module_root_dir}/{$module}"),
            $dir . '/config/main.php' => config_path("{$module_root_dir}_{$module}.php"),
        ]);
    }
}
