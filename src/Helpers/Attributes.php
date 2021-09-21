<?php
namespace Yepwoo\Laragine\Helpers;

use Illuminate\Support\Str;

class Attributes {
    public $columns;
    public $json_data;
    public static $base_path = '\\Core';
    public $str_files_arr = [];

    public function __construct($module, $unit) {
        $this->readJson($module, $unit);
        $this->analyzeData();


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
}
