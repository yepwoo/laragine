<?php

namespace Yepwoo\Laragine\Logic;

use Illuminate\Support\Facades\File;

class FileManipulator
{
    protected static $main_path;

    public static function getTemplate($file, $stubs_vars, $object)
    {
        $replaced_vars = [$object['studly'], $object['plural_lower_case'], $object['singular_lower_case']];
        return str_replace(
            $stubs_vars, $replaced_vars, getStub(__DIR__ . '/../'.self::getMainPath().'/Module' . '\\' . $file)
        );
    }

    public static function generate($file, $stubs_vars, $object, $path)
    {
        self::setMainPath();
        $template = self::getTemplate($file, $stubs_vars, $object);

        file_put_contents(base_path() . '\\core' . "\\" . $object['studly'] . "\\$file", $template);
    }

    private static function setMainPath() {
        self::$main_path = 'core';
    }

    private static function getMainPath() {
        return self::$main_path;
    }
}
