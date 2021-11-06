<?php

namespace Yepwoo\Laragine\Processors;

use Yepwoo\Laragine\Logic\FileManipulator;

class ProcessorFactory
{
    /**
     * processors_data
     *
     */
    public array $processors_data;

    /**
     * create new instance
     *
     * @param $units_data
     * @param array $processors
     * @return ProcessorFactory
     */
    public static function create($units_data, array $processors = [])
    {
        $data2 = array();
        foreach ($processors as $processor) {
            $namespace = self::getNameSpace();
            $class = "{$namespace}". $processor.'Processor';
            $operations = new $class($units_data['module_dir'], $units_data['module_collection'], $units_data['unit_collection']);
            $result_str = $operations->process();
            $data2 = $result_str;
        }

        /**
         * Prepare to call file manipulate
         */
        $source_dir = __DIR__ . '/../Core/Module';;
        $destination_dir   = $units_data['module_dir'];

        $files      = config('laragine.module.unit_folders');
        $search = [
            'file'    => ['stub', 'Api', 'Web', 'Unit'],
            'content' => [
                '#UNIT_NAME#',
                '#MODULE_NAME#',
                '#RESOURCE_STR'
            ]
        ];

        $replace = [
            'file'    => ['php', '', '', $units_data['unit_collection']['studly']],
            'content' => [
                $units_data['unit_collection']['studly'],
                $units_data['unit_collection']['studly'],
                $data2['resource_str']
            ]
        ];
        FileManipulator::generate($source_dir, $destination_dir, $files, $search, $replace);
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
