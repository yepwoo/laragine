<?php
namespace Yepwoo\Laragine\Logic\Validators\Commands;

use Yepwoo\Laragine\Logic\Validators\BaseValidator;


class UnitValidator {

    protected $module;

    protected $unit;

    public function __construct($module, $unit)
    {
        $this->module = $module;
        $this->unit   = $unit;
    }

    /**
     * Validate ordering keys in JSON file in case we want from user to write it with specific order
     *
     * @todo Ask Mahmood if we need this or not
     */
    public function ordering() {

    }
}
