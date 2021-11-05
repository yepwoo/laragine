<?php

namespace Yepwoo\Laragine\Processors;

use Yepwoo\Laragine\Logic\FileManipulator;

class Processor
{
    /**
     * schema data
     * 
     * @var array
     */
    protected $schema;

    /**
     * unit data (its data includes the attributes)
     * 
     * @var array
     */
    protected $unit;

    /**
     * returned data
     * 
     * @var array
     */
    protected $data = [
        'search' => [
            'file'    => ['stub', 'Unit'],
            'content' => ['#UNIT_NAME#', '#MODULE_NAME#', '#CONTENT#']
        ],
        'replace' => [
            'file'    => ['php', 'unit studly'],
            'content' => ['unit studly', 'module studly', '']
        ]
    ];

    /**
     * init
     * 
     * @param array $unit_path
     */
    public function __construct($unit_path)
    {
        $this->schema = FileManipulator::getSchema();
        $this->unit   = FileManipulator::readJson($unit_path);
    }

    /**
     * start processing
     * 
     * @return string[]
     */
    public function process()
    {
        return $this->data;
    }
}
