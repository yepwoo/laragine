<?php

namespace Yepwoo\Laragine\Logic;

/**
 * For collect all errors
 * Class ErrorCollection
 * @package Yepwoo\Laragine\Logic
 */
class ErrorCollection
{

    public static function unitErrors(): array
    {
        return [
            'run_module_first' => 'please run laragine:module name command first',
            'run_init_first'   => 'please run the same command with --init option first'
        ];
    }

}
