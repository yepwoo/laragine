<?php

namespace Yepwoo\Laragine\Processors;

use Yepwoo\Laragine\Logic\FileManipulator;

class Factory
{
    /**
     * processors_data
     *
     * @var array
     */
    public array $processors_data;

    /**
     * create new instance
     *
     * @param  array $units_data
     * @param  array $processors
     * @return void
     */
    public static function create($units_data, array $processors = [])
    {
        $data = [];
        foreach ($processors as $processor_name) {
            $namespace            = self::getNameSpace();
            $class                = "{$namespace}". $processor_name.'Processor';
            $processor            = new $class($units_data['module_dir'], $units_data['module_collection'], $units_data['unit_collection']);
            $processor_str        = strtolower($processor_name) . '_str';
            $data[$processor_str] = $processor->process();
        }

        $source_dir      = __DIR__ . '/../Core/Module';;
        $destination_dir = $units_data['module_dir'];
        $files           = config('laragine.module.unit_folders');

        $search = [
            'file'    => ['date', 'stub', 'Unit', 'units'],
            'content' => [
                '#UNIT_NAME#',
                '#UNIT_NAME_PLURAL_LOWER_CASE#',
                '#UNIT_NAME_PLURAL#',
                '#MODULE_NAME#',
                '#RESOURCE_STR#',
                "#REQUEST_STR#",
                "#FACTORY_STR#",
                "#MIGRATION_STR#",
                '#SELECTED_DIRECTORY#',
            ]
        ];
        $unit_plural_lower = $units_data['unit_collection']['plural_lower_case'];

        $replace = [
            'file'    => [date('Y_m_d_His'), 'php', $units_data['unit_collection']['studly'], $unit_plural_lower],
            'content' => [
                $units_data['unit_collection']['studly'],
                $unit_plural_lower,
                $units_data['unit_collection']['plural'],
                $units_data['module_collection']['studly'],
                $data['resource_str'],
                $data['request_str'],
                $data['factory_str'],
                $data['migration_str'],
                $units_data['selected_directory']
            ]
        ];

        FileManipulator::generate($source_dir, $destination_dir, $files, $search, $replace);
    }

    /**
     * root namespace in which we can use to create new instance of the class passed
     */
    private static function getNameSpace(): string
    {
        return "Yepwoo\Laragine\Processors\\";
    }
}
