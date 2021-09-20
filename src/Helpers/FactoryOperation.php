<?php

namespace Yepwoo\Laragine\Helpers;


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
            $this->factory_file_str .= <<<STR
                        '$key' => \$this->faker->
            STR;
            /**
             * value: {"type": ex....., "mod": .....}
             * check if string contain a (unique) word
             */
            if ($this->containUniqueWord($value['mod'])) {
               $this->factory_file_str .= 'unique()->';
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
                            $this->factory_file_str .= $special_case.'()';
                            break;
                        }

                        if($this->inFactoryTextList($column_value)) {
                            $this->factory_file_str .= 'text(100)';
                            Break;
                        }

                        if ($this->inFactoryIntList($column_value)) {
                            $this->factory_file_str .= 'integer()';
                            Break;
                        }
                        break;
                }
            }

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

    /**
     * @param $column_name
     * Check if column name contain (email - phone - url)
     */
    private function containSpecialCases($column_name) {
        $special_cases = config('laragine.factory_array.special_cases');
        foreach ($special_cases as $case => $factory_key) {
            if (strpos($column_name, $case) !== false) {
               return $factory_key;
            }
        }
        return "not contain";
    }

    /**
     * @param $str
     * Check if the value contain unique word
     */
    private function containUniqueWord($str) {
        if(strpos($str, 'unique') !== false) {
            return true;
        }
        return false;
    }

}
