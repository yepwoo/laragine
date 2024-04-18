<?php

namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Yepwoo\Laragine\Logic\FileManipulator;
use Yepwoo\Laragine\Logic\StringManipulator;

class MakeModule extends Base
{
    /**
     * selected directory (root or plugins)
     *
     * @var string
     */
    protected $selected_dir;

    /**
     * run the logic
     *
     * @return void
     */
    public function run()
    {
        $allow_publish      = true;
        $module_collection  = StringManipulator::generate($this->args[0]);
        $this->selected_dir = $this->args[1] ? $this->plugins_dir : $this->root_dir;
        $module_dir         = $this->selected_dir . '/' . $module_collection['studly'];

        if (!FileManipulator::exists($this->selected_dir)) {
            $allow_publish = false;
            $this->command->error(__('laragine::module.run_install'));
        }

        if (FileManipulator::exists($module_dir)) {
            if ($this->command->confirm(__('laragine::module.exists'), true)) {
                $allow_publish = true;
            } else {
                $allow_publish = false;
                $this->command->warn(__('laragine::module.not_overwritten'));
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
        $source_dir      = __DIR__ . '/../../../Core/Module';
        $destination_dir = $this->selected_dir . '/'. $module_collection['studly'];
        $files           = config('laragine.module.main_files');

        $search = [
            'file'    => ['stub'],
            'content' => [
                '#UNIT_NAME#',
                '#UNIT_NAME_PLURAL_LOWER_CASE#',
                '#UNIT_NAME_LOWER_CASE#',
                '#MODULE_NAME#',
                '#SELECTED_DIRECTORY#',
                '#IS_PLUGINS#'
            ]
        ];

        $replace = [
            'file'    => ['php'],
            'content' => [
                $module_collection['studly'],
                $module_collection['plural_lower_case'],
                $module_collection['singular_lower_case'],
                $module_collection['studly'],
                $this->args[1] ? 'Plugins' : 'Core',
                $this->args[1] ? ', true' : '',
            ]
        ];

        FileManipulator::generate($source_dir, $destination_dir, $files, $search, $replace);
        $this->command->info(__('laragine::module.success'));
    }
}
