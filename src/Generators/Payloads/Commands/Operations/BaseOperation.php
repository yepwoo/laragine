<?php
namespace Yepwoo\Laragine\Generators\Payloads\Commands\Operations;


use Yepwoo\Laragine\Logic\FileManipulator;

class BaseOperation {

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

    public function __construct(...$args)
    {
        $this->module_dir          = $args[0];
        $this->module_collection   = $args[1];
        $this->unit_collection     = $args[2];
        $json_path                 = $this->module_dir . '/data/' . $this->unit_collection['studly'].'.json';

        $this->setSchema()->setJson($json_path);
    }

    public function setSchema(): BaseOperation
    {
        $this->schema = FileManipulator::getSchema();
        return $this;
    }

    public function setJson($path): BaseOperation
    {
        $this->json = FileManipulator::readJson($path);
        return $this;
    }
}
