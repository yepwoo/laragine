<?php
namespace Yepwoo\Laragine\Logic\Validators\Commands;

use Yepwoo\Laragine\Logic\ErrorCollection;
use Yepwoo\Laragine\Logic\FileManipulator;
use Yepwoo\Laragine\Logic\StringManipulator;
use Yepwoo\Laragine\Logic\Validators\ValidatorInterface;


class UnitValidator implements ValidatorInterface {
    /**
     * module
     *
     * @var array
     */
    protected $module;

    /**
     * unit
     *
     * @var array
     */
    protected $unit;

    /**
     * Command
     *
     * @var mixed
     */
    protected $command;

    /**
     * module
     *
     * @var array
     */
    protected $root_dir;

    /**
     * module collection
     *
     * @var array
     */
    protected $module_collection;

    /**
     * module collection
     *
     * @var array
     */
    protected $unit_collection;

    /**
     * error collection
     *
     * @var @array
     */
    protected $error_collection;

    protected $init;
    public function __construct($args)
    {
        $this->module            = $args[0];
        $this->unit              = $args[1];
        $this->command           = $args[2];
        $this->init              = $args[3];
        $this->root_dir          = config("laragine.root_dir");
        $this->module_collection = StringManipulator::generate($this->module);
        $this->unit_collection   = StringManipulator::generate($this->unit);
        $this->error_collection  = ErrorCollection::unitErrors();
    }

    public function valid() {
        $this->handlingPrioritiesCommandsAndOptionsErrors();
    }

    /**
     * Check if the user run module command at first or not
     */
    protected function isRunModuleCommandFirst() {
        if(!FileManipulator::exists($this->root_dir.'/'.$this->module_collection['studly'])) {
            $this->command->error($this->error_collection['run_module_first']);exit;
        }
    }

    /**
     * Will check any file, if exist so it's mean the user run init command
     */
    protected function isRunInitCommand() {
        $unit_paths = config('laragine.module.unit_main_folders');
        $file_name = str_replace('UnitApi', $this->unit_collection['studly'], 'UnitApiController.stub');
        $file_name = str_replace('stub', 'php', $file_name);
        $api_controller_path = $this->root_dir .'/'.$this->module_collection['studly'].'/'."/".$unit_paths['UnitApiController.stub']."/$file_name";

        if(!FileManipulator::exists($api_controller_path) && !$this->init) {
            $this->command->error($this->error_collection['run_init_first']);exit;
        }
    }

    /**
     * Check if user write the module name or not
     */
    protected function isModuleNullable() {

    }

    /**
     * (1) Check if the user run module command at first or not
     * (2) Check if the user run init command at first or not
     * (3) Check if the module option is null or not
     */
    protected function handlingPrioritiesCommandsAndOptionsErrors() {

        // run module command or not
        $this->isRunModuleCommandFirst();

        // run init option first or not
        $this->isRunInitCommand();

        // fill module option or not

    }

}

/**
 * For memories will move it later
 * ============= Errors ===============
 * (1) Check if the user run init command at first or not
 * (2) Check if the user run module command at first or not
 * (3) Check if the user run Init option at first or not
 * (4) Check if the user fill module name in command or not
 */
