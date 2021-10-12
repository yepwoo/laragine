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


        $module_collection = StringManipulator::generate($module_name);
        $source_dir        = __DIR__ . '/../../../Core/Module';
        $destination_dir   = config('laragine.root_dir') . '/'. $module_collection['studly'];
        $files             = config('laragine.module.main_files');

        $path = config('laragine.root_dir').'/'.$module_collection['studly'];

        if (FileManipulator::exists($path)) {
            if (!$this->command->confirm("do you want to override it?", true)) {
                exit;
            }
        }


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
