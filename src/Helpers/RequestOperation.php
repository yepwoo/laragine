<?php
namespace Yepwoo\Laragine\Helpers;

use Illuminate\Support\Str;

class RequestOperation extends Attributes
{
    private $request_file_str;
    private $nullable;

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
            $this->nullable = false;

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
                    case 'mod':
                        $this->addModifiers($column_value);
                        break;
                }
            }
            if ($this->nullable) {
                $this->request_file_str .= 'nullable' . "'";
            } else {
                $this->request_file_str .= 'required' . "'";

            }

            $this->request_file_str .= array_key_last($this->columns) == $key ? ',' : ",\n";
        }
    }

    private function addModifiers($column_value) {
        $modifiers = explode("|", $column_value);
        foreach ($modifiers as $modifier) {
            if ($this->isInRequestArray(strtolower($modifier))) {
                if ($this->isHaveNullableType($modifier)) {
                    $this->nullable = true;
                } else {
                    if($modifier == "unique")
                        $this->request_file_str .= $modifier . ':' . Str::lower(Str::plural($this->unit)) . '|';
                    else
                        $this->request_file_str .= $modifier . '|';
                }
            }
        }
    }

}
