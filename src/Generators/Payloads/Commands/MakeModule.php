<?php

namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Yepwoo\Laragine\Logic\FileManipulator;
use Yepwoo\Laragine\Logic\StringManipulator;

class MakeModule extends Base
{
    /**
     * run the logic
     * 
     * @return void
     */
    public function run()
    {
        $module_name = $this->args[0];

        $validator_factory = \Yepwoo\Laragine\Logic\Validators\ValidatorFactory::create('module', $module_name);
        $callback          = $validator_factory->valid();
        $is_exit           = false;

        switch ($callback['flag']) {
            case 'error':
                $this->{$callback['flag']}($callback['msg']);
                $is_exit = true;
                break;
            case 'confirm':
                if ($this->confirm($callback['msg'], true)) {
                    $is_exit = false;
                }
                break;
            default:
                $this->{$callback['flag']}($callback['msg']);
                break;
        }
        
        if ($is_exit) {
            exit;
        }

        $module_collection = StringManipulator::generate($module_name);
        $source_dir        = __DIR__ . '/../../../Core/Module';
        $destination_dir   = config('laragine.root_dir') . '/'. $module_collection['studly'];
        $files             = $this->config['main_files'];

        $search = [
            'file'    => ['stub'],
            'content' => [
                "#UNIT_NAME#",
                "#UNIT_NAME_PLURAL_LOWER_CASE#",
                "#UNIT_NAME_LOWER_CASE#",
                "#MODULE_NAME#"
            ]
        ];

        $replace = [
            'file'    => ['php'],
            'content' => [
                $module_collection['studly'], 
                $module_collection['plural_lower_case'], 
                $module_collection['singular_lower_case'],
                $module_collection['studly']
            ]
        ];

        FileManipulator::generate_2($source_dir, $destination_dir, $files, $search, $replace);

        $this->command->info('Module created');
    }
}
