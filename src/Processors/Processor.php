<?php

namespace Yepwoo\Laragine\Processors;

use Yepwoo\Laragine\Logic\FileManipulator;

class Processor
{
    /**
     * module names (collection)
     *
     * @var
     */
    public $module_collection;

    /**
     * module dir
     *
     * @var
     */
    public $module_dir;

    /**
     * unit names (collection)
     *
     * @var
     */
    public $unit_collection;

    /**
     * schema
     *
     * @var
     */
    public $schema;

    /**
     * Json
     *
     * @var
     */
    public $json;

    /**
     * processors
     *
     * @var
     */
    public $processors;

    public function __construct(...$args)
    {
        $this->module_dir          = $args[0];
        $this->module_collection   = $args[1];
        $this->unit_collection     = $args[2];
        $json_path = $this->module_dir . '/data/' . $this->unit_collection['studly'].'.json';

        $this->getData()->setSchema()->setJson($json_path);
    }

    /**
     * get data
     *
     * @return Processor
     */
    public function getData(): Processor
    {
        $this->processors = [
            'migration_str' => '',
            'resource_str'  => '',
            'request_str'   => '',
            'factory_str'   => ''
        ];

        return $this;
    }

    public function setSchema(): Processor
    {
        $this->schema = FileManipulator::getSchema();
        return $this;
    }

    public function setJson($path): Processor
    {
        $this->json = FileManipulator::readJson($path);
        return $this;
    }
}
