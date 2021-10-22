<?php

namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Illuminate\Console\Command;
use Yepwoo\Laragine\Logic\StringManipulator;
use Yepwoo\Laragine\Logic\Validators\ValidatorFactory;

class MakeUnit extends Base
{
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
     * init
     *
     * @var boolean
     */
    protected $init;

    /**
     * module collection
     *
     * @var array
     */
    protected $module_collection;

    /**
     * unit collection
     *
     * @var array
     */
    protected $unit_collection;

    public function __construct(Command $command, $args)
    {
        parent::__construct($command, $args);
        $this->module            = $this->args[0];
        $this->unit              = $this->args[1];
        $this->init              = $this->args[2];
        $this->module_collection = StringManipulator::generate($this->module);
        $this->unit_collection   = StringManipulator::generate($this->unit);
    }

    /**
     * run the logic
     *
     * @return void
     */
    public function run()
    {
        $validator = ValidatorFactory::create('Unit', $this->module, $this->unit, $this->command, $this->init);
        $validator->valid();
    }
}
