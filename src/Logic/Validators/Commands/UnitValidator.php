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

    }
}
