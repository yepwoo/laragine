<?php
namespace Yepwoo\Laragine\Generators\Payloads;

use Illuminate\Support\Str;

class GeneratorFactory
{
    public static $message;

    public static function create(string $command, $object): GeneratorInterface
    {
        $namespace = self::getNameSpace();
        $class = "{$namespace}".Str::studly($command);
        return new $class($object);
    }

    private static function getNameSpace(): string
    {
        return "Yepwoo\Laragine\Generators\Payloads\Commands\\";
    }

}
