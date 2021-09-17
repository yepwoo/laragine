<?php
    namespace Yepwoo\Laragine\Helpers;

    use Illuminate\Support\Str;

    class AttributeHelpers {

        public static $base_path = '\\Core';
        public static $json_data = [];

        public static function workOnFile($module, $unit) {
            self::readJson($module, $unit);
            return self::analyzeData();
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
                       return self::getFormatedAttributes($value);

                }
            }
        }

        public static function getFormatedAttributes($attributes): string
        {
            $str = "";
            foreach ($attributes as $key => $value) {
                // key -> column_name (name, phone)
                // every key have (type, mode)
                // load throw type & mod
                foreach ($value as $column => $column_value) {
                    if ($column === 'type') {
                        $str = self::handleTypeCase($column_value, $key, $str);
                    }
                    else if ($column === 'mod') {
                        // $column = mod, $column_value = default:easy|nullable
                        $modifiers = explode("|", $column_value);
                        foreach ($modifiers as $modifier) {
                            $have_value = self::is_modifier_have_value($modifier); //single or multiple
                            if($have_value) {
                                $arr_modifier = explode(':', $modifier);
                                if(count($arr_modifier) < 2 || count($arr_modifier) > 2) {
                                    // @todo error because the user should but value for this modifier and when split by : should length = 2, not lower or higher
                                }
                                $str.= '->' . $arr_modifier[0] . '(' . "'$arr_modifier[1]'" .')';
                            } else {
                                $str .= '->' .$modifier . '()';
                            }
                        }

                    }

                }
                $str.=";
                ";

            }
            return $str;

        }

        public static function handleTypeCase($column_type, $key, $str): string
        {
            $type_of_type = self::multiple_value_type($column_type); //single or multiple
            // get types that have arr value
            $types_have_arr_values = config("laragine.data_types.type_have_array_value");
            $types_have_not_values = config("laragine.data_types.type_without_given_values");

            if($type_of_type === 'multiple') {
                $arr_types = explode('|', $column_type); // expected be one -> ex: enum:2,8, float
                foreach ($arr_types as $type_with_value) {
                    $split_type_to_get_default_values = explode(':', $type_with_value);
                    $type = $split_type_to_get_default_values[0];
                    $value = $split_type_to_get_default_values[1];

                    if (in_array(strtolower($split_type_to_get_default_values[0]), $types_have_arr_values))
                    {
                        $str .= '$table->'.$type.'('. "'$key'". ',' . '['.$value.']' .')';
                    } else
                    {
                        $str .= '$table->'.$type.'('. "'$key'". ',' . $value .')';
                    }

                }
            } else if ($type_of_type === 'single') {
                $arr_types = explode('|', $column_type); // expected be one -> ex: enum:2,8, float

                foreach ($arr_types as $type_without_value) {
                    if (self::containsDots($type_without_value)) {
                        // @todo error handling
                        // here should return error, this type doesn't have a value

                    }
                    if (in_array(strtolower($column_type), $types_have_not_values))
                    {
                        $str .= '$table->'.$type_without_value.'('."'$key'".')';
                    }
                    else {
                        // @todo error handling
                        // here should return error that the type not found
                    }

                }
            }

            return $str;
        }

        /**
         * Check if type is regular or has values like (enum, float)
         */
        public static function multiple_value_type($string): string
        {
            $type_with_given_values = config('laragine.data_types.type_with_given_values');
            foreach ($type_with_given_values as $value) {
                if (strpos($string, $value) !== false) {
                    return 'multiple';
                }
            }
            return 'single';
        }

        /**
         * Check if modifier have value or not
         */

        public static function is_modifier_have_value($modifier_str): bool
        {
            $modifiers_have_values = config('laragine.modifiers.have_values');
            foreach ($modifiers_have_values as $modifier) {
                if (strpos($modifier_str, $modifier) !== false) {
                   return true;
                }
            }
            return false;
        }

        /**
         * Handle Modifier case
         */
        public static function handleModifierCase() {

        }

        /**
         * Check if string contains :
         */
        public static function containsDots($string): bool
        {
            return strpos($string, ":") !== false;
        }
        public static function getTypeValues() {

        }

        public static function getModifireValues() {

        }
    }

