<?php
namespace Yepwoo\Laragine\Generators\Payloads\Commands\Operations;


use Yepwoo\Laragine\Generators\Payloads\Commands\OperationInterface;

class MigrationOperation extends BaseOperation implements OperationInterface {

    public function __construct(...$args)
    {
        parent::__construct(...$args);
    }

    public function run() {
        echo json_encode($this->json);exit;
    }
}
