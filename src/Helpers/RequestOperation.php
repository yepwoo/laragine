<?php
namespace Yepwoo\Laragine\Helpers;

class RequestOperation extends Attributes
{
    private $request_file_str;

    public function __construct($module, $unit)
    {
        parent::__construct($module, $unit);
        $this->request_file_str = &$this->str_files_arr['request_str'];

        $this->handleRequestFile();

    }

    /**
     * Check if type in (request array)
     */
    public function isInRequestArray($column_type): bool
    {
        $db_types_in_request = config('laragine.db_types_in_request');
        foreach ($db_types_in_request as $request_type) {
            if (strpos($request_type, $column_type) !== false) {
                return true;
            }
        }
        return false;
    }

    public function handleRequestFile()
    {
        foreach ($this->columns as $key => $value) { // column name
            $nullable = false;

            foreach ($value as $column => $column_value) { // type name and value
                switch ($column) {
                    case 'type':
                        if ($this->isInRequestArray(strtolower($column_value))) {
                            $lower = strtolower($column_value);

                            $this->request_file_str .= <<<STR
                                            '$key' => '$lower|
                            STR;
                        } else {
                            $this->request_file_str .= <<<STR
                                            '$key' => '
                            STR;
                        }
                        break;
                    case 'modifier':
                        $modifiers = explode("|", $column_value);

                        foreach ($modifiers as $modifier) {
                            $have_value = $this->is_modifier_have_value($modifier); //single or multiple
                            if ($have_value) {
                                if ($this->isHaveNullableType($modifier)) {
                                    $nullable = true;
                                }
                            }
                        }
                }
            }

            if ($nullable) {
                $this->request_file_str .= 'nullable' . "'";
            } else {
                $this->request_file_str .= 'required' . "'";
            }
            $this->request_file_str .= array_key_last($this->columns) == $key ? ',' : ",\n";
        }
    }

    public function isHaveNullableType($str): bool
    {
        return $str === 'nullable';
    }

    /**
     * Check if modifier have value or not
     */

    public function is_modifier_have_value($modifier_str): bool
    {
        $modifiers_have_values = config('laragine.modifiers.have_values');
        foreach ($modifiers_have_values as $modifier) {
            if (strpos($modifier_str, $modifier) !== false) {
                return true;
            }
        }

    }
}
