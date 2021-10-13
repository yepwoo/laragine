<?php

namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Illuminate\Console\Command;
use Yepwoo\Laragine\Logic\FileManipulator;
use Yepwoo\Laragine\Logic\StringManipulator;

class MakeModule extends Base
{
    /**
     * module
     *
     * @var array
     */
    protected $module;

    /**
     * module
     *
     * @var array
     */
    protected $root_dir;

    /**
     * module directory
     *
     * @var array
     */
    protected $module_dir;

    /**
     * module collection
     *
     * @var array
     */
    protected $module_collection;

    public function __construct(Command $command, $args)
    {
        parent::__construct($command, $args);
        $this->module            = $this->args[0];
        $this->root_dir          = config("laragine.root_dir");
        $this->module_collection = StringManipulator::generate($this->module);
        $this->module_dir        = $this->root_dir . '/' . $this->module_collection['studly'];
    }

    /**
     * run the logic
     * 
     * @return void
     */
    public function run()
    {
        $allow_publish = true;

        if (FileManipulator::exists($this->module_dir)) {
            if ($this->command->confirm("the module directory already exists, do you want to override it?", true)) {
                $allow_publish = true;
            } else {
                $allow_publish = false;
                $this->command->warn('Existing module directory was not overwritten');
            }
        }

        if ($allow_publish) {
            $this->publishModuleDirectory();
        }

    }

    protected function publishModuleDirectory() {
        $source_dir        = __DIR__ . '/../../../Core/Module';
        $destination_dir   = config('laragine.root_dir') . '/'. $this->module_collection['studly'];
        $files             = config('laragine.module.main_files');

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
                $this->module_collection['studly'],
                $this->module_collection['plural_lower_case'],
                $this->module_collection['singular_lower_case'],
                $this->module_collection['studly']
            ]
        ];

        FileManipulator::generate_2($source_dir, $destination_dir, $files, $search, $replace);
        $this->command->info('Module created');
    }
}
