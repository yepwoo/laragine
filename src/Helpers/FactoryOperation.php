<?php

namespace Yepwoo\Laragine\Helpers;


use Illuminate\Support\Str;

class FactoryOperation extends Attributes {
    private $factory_file_str;

    public function __construct($module, $unit)
    {
        parent::__construct($module, $unit);
        $this->factory_file_str = &$this->str_files_arr['factory_str'];
        $this->handleFactoryFile();
    }

    public function handleFactoryFile() {
        $special_cases = config('laragine.factory_array.special_cases');

        foreach ($this->columns as $key => $value) {
            $bool = false;
            $temp_str = <<<STR
                        '$key' => \$this->faker->
            STR;


            /**
             * value: {"type": ex....., "mod": .....}
             * check if string contain a (unique) word
             */
            if(isset($value['mod'])) {
                if ($this->containUniqueWord($value['mod'])) {
                    $temp_str .= "unique()->";
                }
            }

            /**
             * ==== special cases ===
             * if key contain email / phone / url
             * will generate factory
             */
            foreach ($value as $column => $column_value) {
                switch ($column) {
                    case 'type':
                        /**
                         * Check first if contains special cases
                         */
                        $special_case = $this->containSpecialCases($key);
                        if ($special_case !== "not contain") {
                            $temp_str .= $special_case.'()';
                            $bool = true;
                            break;
                        }

                        else if($this->inFactoryTextList($column_value)) {
                            $temp_str .= 'text(100)';
                            $bool = true;
                            Break;
                        }

                        else if ($this->inFactoryIntList($column_value)) {
                            $temp_str.= 'integer()';
                            $bool = true;
                            Break;
                        }

                        else if($this->isEnum($column_value)) {
                            $split_arr = explode(":", $column_value);
                            $enum_value_arr = explode(",", $split_arr[1]);

                            $temp_str .= 'randomElement([';
                            foreach ($enum_value_arr as $enum_value) {
                                if(is_numeric($enum_value)) {
                                    $temp_str .= $enum_value_arr[count($enum_value_arr) - 1] === $enum_value ? intval($enum_value) : intval($enum_value) . ',';
                                } else {
                                    $temp_str .= $enum_value_arr[count($enum_value_arr) - 1] === $enum_value ? "'$enum_value'" : "'$enum_value'" . ',';

                                }
                            }

                            $temp_str .= '])';
                            $bool = true;
                            break;
                        }
                        else if($column_value === 'boolean') {
                            $temp_str.= 'boolean()';
                            $bool = true;
                            Break;
                        }
                        break;
                }
            }

            if (!$bool) {
                $temp_str= <<<STR
                             '$key' => ''
                 STR;
            }
            $this->factory_file_str .= $temp_str;
            $this->factory_file_str .= array_key_last($this->columns) == $key ? ',' : ",\n" ;
        }
    }

    private function inFactoryTextList($column_type): bool
    {
        $factory_array = config('laragine.factory_array.text');
        foreach ($factory_array as $request_type) {
            if (strpos($column_type, $request_type) !== false) {
                return true;
            }
        }
        return false;
    }

    private function inFactoryIntList($column_type): bool
    {
        $factory_array = config('laragine.factory_array.integer');
        foreach ($factory_array as $request_type) {
            if (strpos($column_type, $request_type) !== false) {
                return true;
            }
        }
        return false;
    }

    private function isBoolean($column_type): bool
    {
        $factory_array = config('laragine.factory_array.integer');
        foreach ($factory_array as $request_type) {
            if (strpos($column_type, $request_type) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $column_name
     * Check if column name contain (email - phone - url)
     */
    private function containSpecialCases($column_name) {
        $special_cases = config('laragine.factory_array.special_cases');
        foreach ($special_cases as $case => $factory_key) {
            if (strpos(Str::lower($column_name), $case) !== false) {
               return $factory_key;
            }
        }
        return "not contain";
    }

    /**
     * @param $str
     * Check if the value contain unique word
     */
    private function containUniqueWord($str): bool
    {
        if(strpos($str, 'unique') !== false) {
            return true;
        }
        return false;
    }

    private function isEnum($str) {
        if(strpos($str, 'enum') !== false) {
            return true;
        }
        return false;
    }

}
