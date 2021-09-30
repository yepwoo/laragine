<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yepwoo\Laragine\Helpers\MigrationOperation;
use Yepwoo\Laragine\Helpers\ResourceOperation;

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
        $dir = empty($dir) ? base_path().'/core' : $dir;

        // instantiate the loader
        $loader = new \Yepwoo\Laragine\Helpers\Psr4AutoloaderClass;
        // register the autoloader
        $loader->register();
        // register the base directories for the namespace prefix
        $loader->addNamespace($namespace, $dir);
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

if (!function_exists('makeModule')) {
    function makeModules($name): string
    {
        $main_files = config('laragine.module.main_files');
        $unit_folders = config('laragine.module.unit_folders');

        if (!createModule($name)) {
            return 'created before';
        }

        createModuleFiles($main_files, $name);

        createModuleFolders($unit_folders, $name);

        return 'done';
    }
}



if (!function_exists('createModule')) {
    /**
     * === Create module folder ===
     * @param $name
     * @param string $main_path
     */
    function createModule($name, string $main_path = 'core\\') {
        $module_name = Str::studly($name);
        if(!folder_exist('base_path', "core/$module_name")) {
            // create a module folder
            mkdir(base_path() . "\\$main_path/$module_name", 0777, true);
        } else {
            return false;
        }
        return true;
    }
}

/**

 */
if (!function_exists('createModuleFiles')) {
    /**
     * == Create main module files ==
     * - Config/main.php
     * - routes/api.php
     * - routes/web.php
     * @param $main_files
     * @param $name
     * @param string $main_path
     */
    function createModuleFiles($main_files, $name, string $main_path = 'core\\') {
        $module_singular = Str::singular($name);
        $plural_name_lower_case = Str::plural(Str::lower($name));
        $unit_name_lower_case = Str::singular(Str::lower($name));
        $module_name = Str::studly($module_singular);

        foreach ($main_files as $key => $file) {
            $folder = substr($file, 0,strrpos($file, '/'));
            if(!folder_exist('base_path', "core/$module_name/$folder")) {
                mkdir(base_path("core/$module_name/$folder"), 0777, true);
            }
            $stubs_vars    = ["#UNIT_NAME#", "#UNIT_NAME_PLURAL_LOWER_CASE#", "#UNIT_NAME_LOWER_CASE#", "#MODULE_NAME#"];
            $replaced_vars = [$module_name, $plural_name_lower_case, $unit_name_lower_case, $module_name];
            $temp = getTemplate($key, $stubs_vars, $replaced_vars);

            file_put_contents(base_path() . '\\core'."\\$module_name\\$file", $temp);
        }
    }
}



/**
 * == Create main module folders
 */

if (!function_exists('createModuleFolders')) {
    function createModuleFolders($unit_folders, $name) {
        $module_name = Str::studly($name);
        foreach ($unit_folders as $key => $folder) {
            if(!folder_exist('base_path', "core/$module_name/$folder")) {
                mkdir(base_path("core/$module_name/$folder"), 0777, true);
            }
        }
    }
}



/**
 * ================== Unit functions ================
 */

if (!function_exists('createUnitFiles')) {
    function createUnitFiles($name, $module_name, $init = false, string $main_path = 'core\\') {
        $paths = config('laragine.module.unit_folders');
        $advance = config('laragine.module.advance');
        $unit_singular = Str::singular($name);
        $unit_plural_name_lower_case = Str::plural(Str::lower($name));
        $unit_plural_name_ucfirst_case = Str::ucfirst($unit_plural_name_lower_case);
        $unit_studly_case = Str::studly($unit_singular);
        $unit_studly_case_lower = Str::lower($unit_studly_case);
        $module_studly_case_name = Str::studly($module_name);
        $module_studly_name = Str::studly($module_name);
        $errors_obj = new \Yepwoo\Laragine\Helpers\Error($module_name, $unit_studly_case);


        if(!folder_exist('base_path', "core/$module_studly_name")) {
            return 'module_not_exist';
        }

        if ($init) {
            if ($errors_obj->isRunInitCommand()) {
                return 'rerun init command';
            }
            $paths = config('laragine.module.unit_main_folders');
            /**
             * === Create advance files ====
             */
            foreach ($advance as $file => $path) {
                $unit_file_name = getUnitFileName($name, $file);
                $full_path = base_path() . '\\core'."\\$module_studly_name\\$path\\$unit_file_name";

                // create data folder
                if(!folder_exist('base_path', "core/$module_studly_name/$path")) {
                    mkdir(base_path("core/$module_studly_name/$path"), 0777, true);
                }
                $temp = getTemplate($file);
                file_put_contents($full_path, $temp);
            }
        } else {
            if (!$errors_obj->isRunInitCommand()) {
                return 'must run init command';
            }
            
            //copy the unit views
            File::copyDirectory(base_path().'/core/Base/unit_template', base_path()."/core/$module_studly_name/views/$unit_studly_case_lower");
        }

        if (is_null($module_name)) {
            return 'nullable module';
        }


        foreach ($paths as $file => $path) {
            $unit_file_name = getUnitFileName($name, $file);
            $full_path = base_path() . '\\core'."\\$module_studly_name\\$path\\$unit_file_name";

            // create data folder
            if(!folder_exist('base_path', "core/$module_studly_name/$path")) {
                mkdir(base_path("core/$module_studly_name/$path"), 0777, true);
            }

            /**
             * Check if file exist or not, if it's exist it's mean the unit created before
             */
            if (file_exists(base_path() . "/core/$module_studly_name/$path$unit_file_name")) {
                return 'unit exist';
            }

            $stubs_vars    = ["#UNIT_NAME#", "#UNIT_NAME_PLURAL_LOWER_CASE#", "#UNIT_NAME_PLURAL#", "#MODULE_NAME#", "#CONTENT#"];
            $replaced_vars = [
                $unit_studly_case,
                $unit_plural_name_lower_case,
                $unit_plural_name_ucfirst_case,
                $module_studly_case_name,
            ];


            /**
             * Not init case
             */
            if(!$init) {
                 $replaced_vars = casesForNotInitCommand($name, $module_name, $replaced_vars, $errors_obj, $file);
                 if(! is_array($replaced_vars))
                     return $replaced_vars;
            }
            // get template
            $temp = getTemplate($file, $stubs_vars, $replaced_vars);

            file_put_contents($full_path, $temp);
        }


        return 'done';
    }
}

if (!function_exists('handlingErrorMsg')) {
    /**
     * Return error type
     * @param $str
     * @return mixed|string
     */
    function handlingErrorMsg($str)
    {
        if ($str !== 'ok') {
            return $str;
        }

        return 'ok';
    }
}
if (!function_exists('getTemplate')) {
    /**
     * Get template
     * @param array $stubs_vars
     * @param array $replaced_vars
     * @param $file
     * @return array|string|string[]
     */
    function getTemplate($file, array $stubs_vars = [], array $replaced_vars = []) {
        $main_path = 'core\\';
        return str_replace (
            $stubs_vars, $replaced_vars, getStub(__DIR__ . '\\' . $main_path. '\\' . "Module". '\\' .$file)
        );
    }
}


if (!function_exists('getUnitFileName')) {
    /**
     * Get file right name ex: UnitApiController.stub -> PostApiController.php
     * @param $unit_name
     * @param $stub_file
     * @return array|string|string[]
     */
    function getUnitFileName($unit_name, $stub_file) {
        $unit_singular = Str::singular($unit_name);
        $unit_plural_name_lower_case = Str::plural(Str::lower($unit_name));
        $unit_studly_case = Str::studly($unit_singular);

        if(strpos($stub_file, 'units')) { // migration file
            $unit_file_name = date('Y_m_d_His') . '_' . str_replace("units", $unit_plural_name_lower_case, $stub_file);
        } else {
            $unit_file_name = str_replace("Unit", "$unit_studly_case", $stub_file);
            $unit_file_name = str_replace("Api", "", $unit_file_name);
            $unit_file_name = str_replace("Web", "", $unit_file_name);
        }
        return str_replace("stub", "php", $unit_file_name);
    }
}

if(!function_exists('casesForNotInitCommand')) {
    function casesForNotInitCommand($name, $module_name, $replaced_vars, $errors_obj, $file) {
        $unit_singular = Str::singular($name);
        $unit_studly_case = Str::studly($unit_singular);

        $validate = $errors_obj->validate();
        if( handlingErrorMsg($validate) !== 'ok') {
            return handlingErrorMsg($validate);
        }

        switch ($file) {
            case 'create_units_table.stub':
                $migration_object = new MigrationOperation($module_name, $unit_studly_case);
                $attributes = $migration_object->getFilesStrArr();

                array_push($replaced_vars, $attributes['migration_str']);
                break;
            case 'UnitResource.stub':
                $resource_object = new ResourceOperation($module_name, $unit_studly_case);
                $attributes = $resource_object->getFilesStrArr();

                array_push($replaced_vars, $attributes['resource_str']);
                break;
            case 'UnitRequest.stub':
                $resource_object = new \Yepwoo\Laragine\Helpers\RequestOperation($module_name, $unit_studly_case);
                $attributes = $resource_object->getFilesStrArr();
                array_push($replaced_vars, $attributes['request_str']);
                break;

            case 'UnitFactory.stub':
                $resource_object = new \Yepwoo\Laragine\Helpers\FactoryOperation($module_name, $unit_studly_case);
                $attributes = $resource_object->getFilesStrArr();
                array_push($replaced_vars, $attributes['factory_str']);
                break;
        }
         return $replaced_vars;
    }
}
