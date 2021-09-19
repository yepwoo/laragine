<?php

namespace Yepwoo\Laragine\Helpers;


class FactoryOperation extends Attributes {
    private $factory_file_str;

    public function __construct($module, $unit)
    {
        parent::__construct($module, $unit);
        $this->factory_file_str = &$this->str_files_arr['factory_str'];
    }

    public function handleFactoryFile() {
        foreach ($this->columns as $key => $value) {
            foreach ($value as $column => $column_value) {
                switch ($column) {
                    case 'type':
                        if($this->inFactoryList($column_value)) {
                            $this->factory_file_str .= <<<STR
                            '\$table' => \$this->faker
                            STR;

                        }
                        break;
                }
            }
        }
    }

    private function inFactoryList($column_type) {
        $factory_array = config('laragine.factory_array');
        foreach ($factory_array as $request_type) {
            if (strpos($request_type, $column_type) !== false) {
                return true;
            }
        }
        return false;
    }
}
