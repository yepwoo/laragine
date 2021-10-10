<?php
namespace Yepwoo\Laragine\Generators\Payloads;

use Illuminate\Support\Str;

class GeneratorFactory
{
    public static function create(string $command, ...$args): GeneratorInterface
    {
        $namespace = self::getNameSpace();
        $class = "{$namespace}".Str::studly($command);
        return new $class($args);
    }

    private static function getNameSpace(): string
    {
        return "Yepwoo\Laragine\Generators\Payloads\Commands\\";
    }

}
