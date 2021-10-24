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

        if (!FileManipulator::exists($module_dir)) {
            $allow_publish = false;
            $this->command->error('Please create the module first');
        }

        if ($init && FileManipulator::exists("{$module_dir}/data/{$unit_collection['studly']}.json")) {
            $allow_publish = false;
            $this->command->error('You already ran this command before');
        }

        if (!$init && !FileManipulator::exists("{$module_dir}/data/{$unit_collection['studly']}.json")) {
            $allow_publish = false;
            $this->command->error('Please type --init at the end of the command');
        }

        /**
         * @todo check migrations, factories, requests, resources and tests as it's currently check for requests
         */
        if (!$init && FileManipulator::exists("{$module_dir}/Requests/{$unit_collection['studly']}Request.php")) {
            if ($this->command->confirm('the unit already exists, do you want to override it?', true)) {
                $allow_publish = true;
            } else {
                $allow_publish = false;
                $this->command->warn('Existing unit was not overwritten');
            }
        }

        // $validator = ValidatorFactory::create(
        //     'Unit',
        //     $module_collection['studly'],
        //     $unit_collection['studly'],
        //     $this->command,
        //     $init
        // );

        // $validator->valid();

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
