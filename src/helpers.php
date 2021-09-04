<?php

use Illuminate\Support\Facades\File;

if (!function_exists('dummy_function')) {
    /**
     * get the dummy function.
     *
     * @param string $dummy
     * @return string
     */
    function dummy_function($dummy = '')
    {
        return $dummy;
    }
}

if (!function_exists('create_config_folder')) {

    /**
     * Create new Config folder
     * Key for know if this folder creates for base or other module
     * @param string $key
     * @param string $path
     * @return string
     */
    function create_folders(string $key, array $names = [])
    {

    }
}

if (!function_exists('folder_exist')) {

    /**
     * Check if folder exist or not
     * Key refer to main paths helper function in laravel
        * app_path - resource_path - config_path - ....
        *  (app - resource - migration -...)
     * @param string $key
     * @param string $path
     * @return string
     */
    function folder_exist(string $key, string $path = ''): string
    {
        return File::isDirectory($key($path));
    }
}


if (!function_exists('getStub')) {
    function getStub(string $path): string
    {
        return file_get_contents($path);
    }
}
