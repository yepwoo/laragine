<?php
namespace Yepwoo\Laragine\Helpers;

use Illuminate\Support\Str;

class Attributes {
    public $columns;
    public $json_data;
    public static $base_path = '\\core';
    public $str_files_arr = [];
    protected $module;
    protected $unit;

    public $callback = 'done';

    public function __construct($module, $unit) {
        $this->unit = $unit;
        $this->module = $module;

        if($this->isRunInitCommand()) {
            $this->readJson($module, $unit);
            $this->analyzeData();
        }

    }

    private function readJson($module, $unit) {
        $module_studly_name = Str::studly($module);
        $unit_studly_name   = Str::studly($unit);

        $path = base_path(). self::$base_path . "\\$module_studly_name\\data\\$unit_studly_name.json";
        $readJsonFile = file_get_contents($path);

        $this->json_data = json_decode($readJsonFile, true);
    }

    private function analyzeData() {
        $json_data = $this->json_data;
        foreach ($json_data as $key => $value) {
            switch ($key) {
                case 'attributes':
                    $this->columns = $value;
            }
        }
    }

    public function getFilesStrArr(): array
    {
        return $this->str_files_arr;
    }


    /**
     * Check type of modifier, if it's type of (having value or not)
     * @param $modifier_str
     * @return bool
     */
    public function is_modifier_have_value($modifier_str): bool
    {
        $modifiers_have_values = config('laragine.modifiers.have_values');
        foreach ($modifiers_have_values as $modifier) {
            if (strpos($modifier_str, $modifier) !== false) {
                return true;
            }
        }
        return false;
    }

    public static function isHaveNullableType($str): bool
    {
        return $str === 'nullable';
    }

    /**
     * Will check any file, if exist so it's mean the user run init command
     */
    public function isRunInitCommand(): bool
    {
        $init_paths = config('laragine.module.unit_main_folders');
        $module_studly_name = Str::studly($this->module);
        $unit_studly_case = Str::studly($this->unit);
        $api_controller_path = $init_paths['UnitApiController.stub'];
        $file_name = str_replace('UnitApi', $unit_studly_case, 'UnitApiController.stub');
        $file_name = str_replace('stub', 'php', $file_name);
        // create data folder
        if(file_exists(base_path()."/core/$module_studly_name/$api_controller_path/$file_name")) {
            return true;
        }
        return false;

    }
}
