<?php

namespace Yepwoo\Laragine\Processors;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Yepwoo\Laragine\Generators\Payloads\Commands\Operations\BaseOperation;
use Yepwoo\Laragine\Logic\FileManipulator;

class ProcessorFactory
{
    /**
     * operation
     *
     */
    public ProcessorInterface $operation;
    /**
     * create new instance
     *
     * @param $units_data
     * @param array $args
     * @return ProcessorFactory
     */
    public static function create($units_data, array $processors = []): ProcessorFactory
    {
        $data = array();
        array_map(function ($processor) use ($units_data){
            $namespace = self::getNameSpace();
            $class = "{$namespace}". $processor.'Processor';
            $operations = new $class($units_data['module_dir'], $units_data['module_collection'], $units_data['unit_collection']);
            $result_str = $operations->process();
            $data[strtolower($processor).'_str'] = $result_str;
        }, $processors);


        // prepare to call file manipulate
        exit;
    }

    /**
     * root namespace in which we can use to create new instance of the class passed
     *
     * @return string
     */
    private static function getNameSpace(): string
    {
        return "Yepwoo\Laragine\Processors\\";
    }
}
