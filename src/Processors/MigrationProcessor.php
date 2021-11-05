<?php
namespace Yepwoo\Laragine\Processors;


use Monolog\Processor\ProcessorInterface;

class MigrationProcessor extends BaseOperation implements ProcessorInterface {

    /**
     * Migration str
     *
     * @var string
     */
    public string $migration_str;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
    }

    public function run() {
        $this->getColumns();
    }

    public function getColumns() {
        $attributes = $this->json['attributes'];
        foreach ($attributes as $column => $cases) {
            $this->typeCase($cases['type']);
        }
    }

    public function typeCase($value) {
        echo json_encode($value);exit;
    }

    public function modCase() {

    }

}
