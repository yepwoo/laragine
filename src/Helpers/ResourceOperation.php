<?php
namespace Yepwoo\Laragine\Helpers;

class ResourceOperation extends Attributes {

    private $resource_file_str;
    public function __construct($module, $unit)
    {
        parent::__construct($module, $unit);
        $this->resource_file_str = &$this->str_files_arr['resource_str'];

        $this->getFormattedResourceStr();
    }

    public function getFormattedResourceStr() {
        foreach ($this->columns as $key => $value) { // column name
            $this->resource_file_str .= <<<STR
                                    '$key' => \$this->$key
                        STR;
        $this->resource_file_str  .= array_key_last($this->columns) == $key ? ',' : ",\n";
        }


    }
}
