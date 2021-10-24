<?php

namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Yepwoo\Laragine\Logic\StringManipulator;
use Yepwoo\Laragine\Validations\UnitValidation;

class MakeUnit extends Base
{
    /**
     * run the logic
     *
     * @return void
     */
    public function run()
    {
        $allow_publish     = true;
        $unit_collection   = StringManipulator::generate($this->args[0]);
        $module_collection = StringManipulator::generate($this->args[1]);
        $init              = $this->args[2];
        $module_dir        = $this->root_dir . '/' . $module_collection['studly'];

        $validation = new UnitValidation($this->command);
        $validation->checkModule($module_dir)
                   ->checkUnit($module_dir, $unit_collection, $init);

        if ($validation->allow_proceed) {
            $this->publishUnit();
        }
    }

    /**
     * publish unit
     * 
     * @return void
     */
    protected function publishUnit()
    {

    }
}
