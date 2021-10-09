<?php

namespace Yepwoo\Laragine\Logic\Validators\Commands;

use Illuminate\Support\Facades\File;
use Yepwoo\Laragine\Logic\Validators\BaseValidator;
use Yepwoo\Laragine\Logic\StringManipulator;
use Yepwoo\Laragine\Logic\Validators\ValidatorInterface;

class ModuleValidator extends BaseValidator implements ValidatorInterface
{
    private $module;
    private $path;
    private $module_names;

    public function __construct($module) {  
        $this->module = $module;
        $this->module_names = StringManipulator::generate($this->module[0]);

        $this->path = config('laragine.root_dir').'/'.$this->module_names['studly']; 

        parent::__construct();
    }

    public function valid() {
        $this->isExists($this->path, $this->module[0] . ' Exists, do you want to override it?');

        $this->test();

        return $this->callback;
        // func2

        // func3

        
    }

    public function test() {
        if ($this->stillValid()) {
            /**
             * Write some code
             */
        }
    }


}