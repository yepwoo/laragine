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
     * processors
     *
     * @var
     */
    protected $processors;

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

        $this->setProcessors()->setSchema()->setJson();
    }

    /**
     * set the processors
     */
    public function setProcessors(): Processor
    {
        $this->processors = [
            'migration_str' => '',
            'resource_str'  => '',
            'request_str'   => '',
            'factory_str'   => ''
        ];

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
    protected function isSchemaTypeFound($type): bool
    {
        return isset($this->schema['types'][$type]);
    }
}
