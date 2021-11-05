<?php

namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Yepwoo\Laragine\Generators\Payloads\Commands\Operations\BaseOperation;

class OperationFactory
{
    /**
     * operation
     *
     */
    public OperationInterface $operation;
    /**
     * create new instance
     *
     * @param $units_data
     * @param array $args
     * @return OperationFactory
     */
    public static function create($units_data, array $operations = []): OperationFactory
    {
        array_map(function ($operation) use ($units_data){
            $namespace = self::getNameSpace();
            $class = "{$namespace}". $operation.'Operation';
            $operations = new $class($units_data['module_dir'], $units_data['module_collection'], $units_data['unit_collection']);
            $operations->run();
        }, $operations);
        exit;
    }

    /**
     * root namespace in which we can use to create new instance of the class passed
     *
     * @return string
     */
    private static function getNameSpace(): string
    {
        return "Yepwoo\Laragine\Generators\Payloads\Commands\Operations\\";
    }
}
