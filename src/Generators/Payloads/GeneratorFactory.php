<?php
namespace Yepwoo\Laragine\Generators\Payloads;

use Illuminate\Support\Str;
use Yepwoo\Laragine\Generators\Payloads\Commands\Install;
use Yepwoo\Laragine\Generators\Payloads\Commands\MakeModule;
use Yepwoo\Laragine\Generators\Payloads\Commands\MakeUnit;

class GeneratorFactory
{

    public static function create(string $command): GeneratorInterface
    {
        $namespace = self::getNameSpace();
        $class = "{$namespace}".Str::studly($command);
        return new $class();
    }

    private static function getNameSpace(): string
    {
        return "Yepwoo\Laragine\Generators\Payloads\Commands\\";
    }

}
