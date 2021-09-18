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

    public function setFileStrArr($value, $key) {
        $this->str_files_arr[$key] = $value;
    }
}
