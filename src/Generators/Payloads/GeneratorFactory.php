<?php
namespace Yepwoo\Laragine\Generators\Payloads;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GeneratorFactory
{
    /**
     * create new instance
     * 
     * @param  Command $command
     * @param  string  $class
     * @param  array   $args
     * @return GeneratorInterface
     */
    public static function create(Command $command, string $class, ...$args): GeneratorInterface
    {
        $namespace = self::getNameSpace();
        $class = "{$namespace}".Str::studly($class);
        return new $class($command, $args);
    }

    /**
     * root namespace in which we can use to create new instance of the class passed
     * 
     * @return string
     */
    private static function getNameSpace(): string
    {
        return "Yepwoo\Laragine\Generators\Payloads\Commands\\";
    }
}
