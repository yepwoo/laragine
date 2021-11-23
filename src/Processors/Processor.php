<?php

namespace Yepwoo\Laragine\Processors;

use Yepwoo\Laragine\Logic\FileManipulator;

class Processor
{
    /**
     * module forms (collection)
     *
     * @var
     */
    protected $module_collection;

    /**
     * module dir
     *
     * @var
     */
    protected $module_dir;

    /**
     * unit forms (collection)
     *
     * @var
     */
    protected $unit_collection;

    /**
     * schema
     *
     * @var
     */
    protected $schema;

    /**
     * json data (the json that contains the attributes for the unit)
     *
     * @var
     */
    protected $json;

    /**
     * processor
     *
     * @var
     */
    protected string $processor;

    /**
     * init
     *
     * @param array $args
     */
    public function __construct(...$args)
    {
        $this->module_dir          = $args[0];
        $this->module_collection   = $args[1];
        $this->unit_collection     = $args[2];

        $this->setProcessor()->setSchema()->setJson();
    }

    /**
     * set the processor
     */
    public function setProcessor(): Processor
    {
        $this->processor = '';
        return $this;
    }

    /**
     * set the schema
     */
    public function setSchema(): Processor
    {
        $this->schema = FileManipulator::getSchema();
        return $this;
    }

    /**
     * set the json
     */
    public function setJson(): Processor
    {
        $json_path  = $this->module_dir . '/data/' . $this->unit_collection['studly'].'.json';
        $this->json = FileManipulator::readJson($json_path);
        return $this;
    }

    /**
     * Check if type is in our schema
     *
     * @param $type
     * @return bool
     */
    protected function isSchemaFound($prop, $type): bool
    {
        return isset($this->schema[$prop][$type]);
    }

    protected function isOneValueType($str): bool
    {
        return $str == 'one_value_argument';
    }
}
