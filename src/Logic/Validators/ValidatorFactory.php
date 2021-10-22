<?php
namespace Yepwoo\Laragine\Logic\Validators;

use Illuminate\Support\Str;

class ValidatorFactory
{
    public static $message;

    public static function create(string $command, ...$args): ValidatorInterface
    {
        $namespace = self::getNameSpace();
        $class = "{$namespace}".Str::studly($command)."Validator";
        return new $class($args);
    }

    private static function getNameSpace(): string
    {
        return "Yepwoo\Laragine\Logic\Validators\Commands\\";
    }

}
