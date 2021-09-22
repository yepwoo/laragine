<?php
namespace Yepwoo\Laragine\Helpers;

class MigrationOperation extends Attributes {

    private $migration_file_str;
    public function __construct($module, $unit)
    {
        parent::__construct($module, $unit);
        $this->migration_file_str = &$this->str_files_arr['migration_str'];
        $this->getFormattedAttributes();
    }

    public function getFormattedAttributes() {
        foreach ($this->columns as $key => $value) { // column name
            foreach ($value as $column => $column_value) { // type name and value
                switch ($column) {
                    case 'type':
                        $this->handleTypeCase($column_value, $key);
                        break;
                    case 'mod':
                        $modifiers = explode("|", $column_value);
                        foreach ($modifiers as $modifier) {
                            $have_value = $this->is_modifier_have_value($modifier); //single or multiple
                            if ($have_value) {
                                $arr_modifier = explode(':', $modifier);
                                $this->migration_file_str.= '->' . $arr_modifier[0] . '(' . "'$arr_modifier[1]'" .')';
                            } else {
                                $this->migration_file_str .= '->' .$modifier . '()';
                            }
                        }
                        break;
                }
            }
            $this->migration_file_str .= array_key_last($this->columns) == $key ? ';' : ";\n" ;
        }
    }

    private function handleTypeCase($column_type, $key) {
        $type_of_type = $this->multipleOrSingle($column_type); //single or multiple
        $types_have_arr_values = config("laragine.data_types.type_have_array_value");
        $types_have_not_values = config("laragine.data_types.type_without_given_values");

        switch ($type_of_type) {
            case 'multiple' :
                $this->multipleTypeCase($column_type, $types_have_arr_values, $key);
            case 'single':
                $this->singleTypeCase($column_type, $types_have_not_values, $key);
        }
    }


    private function multipleOrSingle($string): string
    {
        $type_with_given_values = config('laragine.data_types.type_with_given_values');
        foreach ($type_with_given_values as $value) {
            if ($this->isMultipleType($string, $value)) {
                return 'multiple';
            }
        }
        return 'single';
    }

    private function multipleTypeCase($column_type, $types_have_arr_values, $key) {
        $arr_types = explode('|', $column_type); // expected be one -> ex: enum:2,8, float
        foreach ($arr_types as $type_with_value) {
            $split_type_to_get_default_values = explode(':', $type_with_value);
            $type = $split_type_to_get_default_values[0];
            $value = $split_type_to_get_default_values[1];

            if (in_array(strtolower($split_type_to_get_default_values[0]), $types_have_arr_values))
            {
                $this->migration_file_str .= <<<STR
                                    \$table->$type('$key', [$value])
                        STR;

            } else
            {
                $this->migration_file_str .= <<<STR
                                    \$table->$type('$key', $value)
                        STR;
            }

        }
    }

    private function singleTypeCase($column_type, $types_have_not_values, $key) {
        $arr_types = explode('|', $column_type); // expected be one -> ex: enum:2,8, float

        foreach ($arr_types as $type_without_value) {
            if (in_array(strtolower($column_type), $types_have_not_values))
            {

                $this->migration_file_str .= '$table->'.$type_without_value.'('."'$key'".')';
            }
        }
    }

    private function isMultipleType($string, $value): bool
    {
        return strpos($string, $value) !== false;
    }

}
