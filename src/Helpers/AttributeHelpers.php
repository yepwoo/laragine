<?php
    namespace Yepwoo\Laragine\Helpers;

    use Illuminate\Support\Str;

    class AttributeHelpers {

        public static $base_path = '\\Core';
        public static $json_data = [];

        public static function workOnFile($module, $unit) {
            self::readJson($module, $unit);
            self::analyzeData();
        }
        public static function readJson($module, $unit)
        {
            $module_studly_name = Str::studly($module);
            $unit_studly_name   = Str::studly($unit);

            $path = base_path(). self::$base_path . "\\$module_studly_name\\data\\$unit_studly_name.json";
            $readJsonFile = file_get_contents($path);

            self::$json_data = json_decode($readJsonFile, true);
        }

        public static function analyzeData() {
            $json_data = self::$json_data;
            foreach ($json_data as $key => $value) {
                switch ($key) {
                    case 'attributes':
                        self::getAttributes($value);

                }
            }
        }

        public static function getAttributes($attributes) {
            foreach ($attributes as $key => $value) {

            }
            exit;
        }
        public static function g() {

        }
    }

