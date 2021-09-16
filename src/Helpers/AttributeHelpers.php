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
            $type_with_given_values = config('laragine.type_with_given_values');
            $str = "";
            foreach ($attributes as $key => $value) {
                // key -> column_name (name, phone)
                // every key have (type, mode)
                // load throw type & mod
                foreach ($value as $column => $column_type) {
                    $type_of_type = self::multiple_value_type($column_type); //single or multiple

                    if($type_of_type === 'multiple') {
                        $arr_types = explode('|', $column_type); // expected be one -> ex: enum:2,8, float
                        foreach ($arr_types as $type_with_value) {
                            $split_type_to_get_default_values = explode(':', $type_with_value);
                            $type = $split_type_to_get_default_values[0];
                            $value = $split_type_to_get_default_values[1];
                            if ($split_type_to_get_default_values[0] === 'enum')
                            {
                                 $str .= '$this->'.$type.'('.$key. ',' . '['.$value.']' .')';
                            } else
                            {
                                $str .= '$this->'.$type.'('.$key. ',' . $value .');';
                            }

                        }
                    }

                    $str .= "
                    ";
                }
                /**
                 * key (column name)
                 * $value (type, mod)
                    * loop through $value
                        * key(type, mod)
                        * value (ex: enum, default)
                            * should explode by (|), loop and get value by (:)
                 */
            }
            echo json_encode($str);exit;
            exit;
        }

        /**
         * Check if type is regular or has values like (enum, float)
         */
        public static function multiple_value_type($string) {
            $type_with_given_values = config('laragine.type_with_given_values');
            foreach ($type_with_given_values as $value) {
                if (strpos($string, $value) !== false) {
                    return 'multiple';
                }
            }
            return 'single';
        }
        public static function getTypeValues() {

        }

        public static function getModifireValues() {

        }
    }

