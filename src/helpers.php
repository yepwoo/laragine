<?php

if (!function_exists('client_validation_response')) {
    /**
     * get the validation message formatted for client side.
     *
     * @param array  $validations
     * @param int    $start_code
     * @return array
     */
    function client_validation_response($validations, &$start_code = 4101)
    {
        $array = [];

        foreach ($validations as $key => $validation) {

            if ($key == 'custom' || $key == 'attributes') {
                continue;
            }

            if (is_array($validation)) {
                $array[$key] = client_validation_response($validation, $start_code);
            } else {
                $array[$key] = [
                    config('laragine.validation.message') => $validation,
                    config('laragine.validation.code')    => $start_code
                ];

                $start_code++;
            }
        }

        return $array;
    }
}

if (!function_exists('module_autoloader')) {
    /**
     * Psr4 Autoloader helper.
     *
     * @param string $namespace
     * @param string $dir
     * @return void
     */
    function module_autoloader($namespace = 'Core', $dir = '')
    {
        $dir = empty($dir) ? config('laragine.root_dir') : $dir;

        // instantiate the loader
        $loader = new \Yepwoo\Laragine\Support\Psr4AutoloaderClass;
        // register the autoloader
        $loader->register();
        // register the base directories for the namespace prefix
        $loader->addNamespace($namespace, $dir);
    }
}