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
        $allow_publish     = true;
        $module_collection = StringManipulator::generate($this->args[0]);
        $module_dir        = $this->root_dir . '/' . $module_collection['studly'];

        if(!FileManipulator::exists($this->root_dir)) {
            $allow_publish = false;
            $this->command->error('Please run install command first');
        }

        if (FileManipulator::exists($module_dir)) {
            if ($this->command->confirm('the module directory already exists, do you want to override it?', true)) {
                $allow_publish = true;
            } else {
                $allow_publish = false;
                $this->command->warn('Existing module directory was not overwritten');
            }
        }

        if ($allow_publish) {
            $this->publishModuleDirectory($module_collection);
        }
    }

    /**
     * publish module directory
     * 
     * @param  string[] $module_collection
     * @return void
     */
    protected function publishModuleDirectory($module_collection)
    {
        $source_dir        = __DIR__ . '/../../../Core/Module';
        $destination_dir   = $this->root_dir . '/'. $module_collection['studly'];
        $files             = config('laragine.module.main_files');

        $search = [
            'file'    => ['stub'],
            'content' => [
                '#UNIT_NAME#',
                '#UNIT_NAME_PLURAL_LOWER_CASE#',
                '#UNIT_NAME_LOWER_CASE#',
                '#MODULE_NAME#'
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
        $this->command->info('Module created successfully!');
    }
}
