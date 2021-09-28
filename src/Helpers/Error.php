<?php
namespace Yepwoo\Laragine\Helpers;

use Illuminate\Support\Str;

class Error extends Attributes {

    public function __construct($module, $unit) {
        parent::__construct($module, $unit);
    }

    public function validate(): string
    {
        return $this->validateAttributes($this->columns);
    }

    public function validateAttributes($attributes): string
    {
        foreach ($attributes as $key => $value) {
            foreach ($value as $column => $column_value) {
                if (array_key_first($value) !== 'type') {
                    return 'ordering error';
                }

                if($column === 'mod') {
                        $response = $this->validateModifiers($column_value);
                        if($response !== 'ok')
                            return $response;

                } else if ($column === 'type') {
                        $response = $this->validateTypes($column_value);
                        if($response !== 'ok')
                            return $response;
                }
            }
        }
        return 'ok';
    }

    private function validateModifiers($value): string
    {
        $modifiers = explode('|', $value);
        foreach ($modifiers as $modifier) {
            $have_value = $this->is_modifier_have_value($modifier); //single or multiple
            if($have_value) {
                $arr_modifier = explode(':', $modifier);
                if (count($arr_modifier) !== 2) {
                    return 'mod syntax error';
                }
            }
        }
        return 'ok';
    }
    private function validateTypes($column_type): string
    {
        if ($this->isSingle($column_type)) {
            if ($this->containsDots($column_type)) {
                return 'single type have value error';
            }
        }
        if(!$this->isSingle($column_type) && !$this->isMultiple($column_type)) {
            return 'undefined type';
        }

        return 'ok';
    }

    private function isSingle($column_type): bool
    {
        $arr_types = explode('|', $column_type); // expected be one -> ex: enum:2,8, float
        $types_have_not_values = config("laragine.data_types.type_without_given_values");

        foreach ($arr_types as $type_without_value) {
            $type_arr = explode(':', $type_without_value);
            if (in_array(Str::camel($type_arr[0]), $types_have_not_values))
            {
                return true;
            }
        }
        return false;
    }

    private function isMultiple($column_type): bool
    {
        $arr_types = explode('|', $column_type);

        $types_with_given_values = config("laragine.data_types.type_with_given_values");
        foreach ($arr_types as $type) {
            $multiple_type = explode(":", $type);
            if(count($multiple_type) > 1) { // this mean the type have multiple value
                if (!in_array(Str::camel($multiple_type[0]), $types_with_given_values))
                {
                    return false;
                }
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if string contains :
     */
    public function containsDots($string): bool
    {
        return strpos($string, ":") !== false;
    }

}
