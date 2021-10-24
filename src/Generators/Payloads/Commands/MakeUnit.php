<?php

namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Yepwoo\Laragine\Logic\FileManipulator;
use Yepwoo\Laragine\Logic\StringManipulator;
use Yepwoo\Laragine\Logic\Validators\ValidatorFactory;

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

        if(!FileManipulator::exists($module_dir)) {
            $allow_publish = false;
            $this->command->error('Please create the module first');
        }

        $validator = ValidatorFactory::create(
            'Unit',
            $module_collection['studly'],
            $unit_collection['studly'],
            $this->command,
            $init
        );

        $validator->valid();

        if ($allow_publish) {
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
