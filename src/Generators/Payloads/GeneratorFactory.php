<?php
namespace Yepwoo\Laragine\Generators\Payloads;

use Yepwoo\Laragine\Generators\Payloads\Commands\Install;
use Yepwoo\Laragine\Generators\Payloads\Commands\MakeModule;
use Yepwoo\Laragine\Generators\Payloads\Commands\MakeUnit;

class GeneratorFactory
{

    public static function create(string $command): GeneratorInterface
    {
        switch ($command) {
            case 'install':
                return new Install();
                break;
            case 'make-module':
                return new MakeModule();
                break;
            case 'make-unit':
                return new MakeUnit();
                break;
        }
    }

}
