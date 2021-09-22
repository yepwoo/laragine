<?php
    namespace Yepwoo\Laragine\Helpers;

    use Illuminate\Support\Str;

    class AttributeHelpers {

        public static $base_path = '\\core';
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

        public static function getFormatedAttributes($attributes): array
        {
            $arr_of_files = [
                'migration_str' => "",
                'resource_str'  => "",
                'request_str'   => ""
            ];
            $migration_file_str = &$arr_of_files['migration_str'];
            $resource_file_str  = &$arr_of_files['resource_str'];
            $request_file_str   = &$arr_of_files['request_str'];

            foreach ($attributes as $key => $value) {

                // key -> column_name (name, phone)
                // every key have (type, mode)
                // load throw type & mod
                $nullable = false;
                foreach ($value as $column => $column_value) {
                    if ($column === 'type') {
                        $arr_of_files = self::handleTypeCase($column_value, $key, $arr_of_files);

                        /**
                         * === we don't need to put the resource str in mode, just we need the column name (key)
                         */
                        $resource_file_str .= <<<STR
                                    '$key' => \$this->$key
                        STR;
                    }
                    else if ($column === 'mod') {
                        // $column = mod, $column_value = default:easy|nullable
                        $modifiers = explode("|", $column_value);
                        foreach ($modifiers as $modifier) {
                            $have_value = self::is_modifier_have_value($modifier); //single or multiple
                            if($have_value) {
                                $arr_modifier = explode(':', $modifier);
                                if (count($arr_modifier) < 2 || count($arr_modifier) > 2) {
                                    // @todo error because the user should but value for this modifier and when split by : should length = 2, not lower or higher
                                }
                                $migration_file_str.= '->' . $arr_modifier[0] . '(' . "'$arr_modifier[1]'" .')';
                            } else {
                                if (self::isHaveNullableType($modifier)) {
                                    $nullable = true;
                                }
                                $migration_file_str .= '->' .$modifier . '()';
                            }
                        }

                    }

                }
                if ($nullable) {
                    $request_file_str .= 'nullable' . "'";
                } else {
                    $request_file_str .= 'required' . "'";
                }

                $migration_file_str .= array_key_last($attributes) == $key ? ';' : ";\n" ;
                $resource_file_str  .= array_key_last($attributes) == $key ? ',' : ",\n";
                $request_file_str   .= array_key_last($attributes) == $key ? ',' : ",\n";
            }
            return $arr_of_files;

        }

        public static function handleTypeCase($column_type, $key, &$arr): array
        {
            $migration_str = $arr['migration_str'];
            $resource_str  = $arr['resource_str'];
            $request_str   = $arr['request_str'];

            $type_of_type = self::multiple_value_type($column_type); //single or multiple
            // get types that have arr value
            $types_have_arr_values = config("laragine.data_types.type_have_array_value");
            $types_have_not_values = config("laragine.data_types.type_without_given_values");

            /**
             * === Working on Request ====
             */
            if (self::inRequestArray(strtolower($column_type))) {
                $lower = strtolower($column_type);

                $request_str .= <<<STR
                                    '$key' => '$lower|
                STR;
            } else {
                $request_str .= <<<STR
                                    '$key' => '
                STR;
            }


            if($type_of_type === 'multiple') {
                $arr_types = explode('|', $column_type); // expected be one -> ex: enum:2,8, float
                foreach ($arr_types as $type_with_value) {
                    $split_type_to_get_default_values = explode(':', $type_with_value);
                    $type = $split_type_to_get_default_values[0];
                    $value = $split_type_to_get_default_values[1];

                    if (in_array(strtolower($split_type_to_get_default_values[0]), $types_have_arr_values))
                    {
                        $migration_str .= <<<STR
                                    \$table->$type('$key', [$value])
                        STR;

                    } else
                    {
                        $migration_str .= <<<STR
                                    \$table->$type('$key', $value)
                        STR;   
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

                        $migration_str .= '$table->'.$type_without_value.'('."'$key'".')';
                    }
                    else {
                        // @todo error handling
                        // here should return error that the type not found
                    }

                }
            }
            $arr['migration_str'] = $migration_str;
            $arr['resource_str']  = $resource_str;
            $arr['request_str']  =  $request_str;

            return $arr;
        }

        /**
         * Check if type in (request array) -> (string - integer)
         */
        public static function inRequestArray($column_type): bool
        {
            $db_types_in_request = config('laragine.db_types_in_request');
            foreach ($db_types_in_request as $request_type) {
                if (strpos($request_type, $column_type) !== false) {
                    return true;
                }
            }
            return false;
        }

        /**
         * === handle working on request str ====
         */

        public static function handleWorkingOnRequest($column_type, $request_str, $key, $first = true): string
        {
            if ($first) {
                if (self::inRequestArray(strtolower($column_type))) {
                    $lower = strtolower($column_type);
                    $request_str   .= "'$key'" . '=>' . "'$lower|";

                } else {
                  $request_str     .= "'$key'" . '=>' . "'";
                }
            }

            return $request_str;
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

        public static function isHaveNullableType($str): bool
        {
            return $str === 'nullable';
        }
    }

