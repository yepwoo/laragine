<?php

namespace Yepwoo\Laragine\Logic;

use Illuminate\Support\Facades\File;

class FileManipulator
{
    protected static $main_path;

    /**
     * generate the files (I will call it generate_2 for now as there is another static method called generate)
     * 
     * @param  string   $source_dir
     * @param  string   $destination_dir
     * @param  string[] $files
     * @param  string[] $search  str_replace first param
     * @param  string[] $replace str_replace second param
     * @return void
     */
    public function generate_2($source_dir, $destination_dir, $files, $search = [], $replace = [])
    {
        foreach ($files as $name => $destination) {
            $file    = $name;
            $content = $source_dir . '/' .$file;

            if (strpos($destination, '.') !== false) {
                if (strpos($destination, '/') !== false) {
                    $file        = substr($destination, strrpos($destination, '/') + 1);
                    $destination = 'get string before slash';
                } else {
                    $file        = $destination;
                    $destination = '';
                }
            } else if (isset($search['file']) && isset($replace['file'])) {
                $file = str_replace($search['file'], $replace['file'], $file);
            }

            if (isset($search['content']) && isset($replace['content'])) {
                $content = str_replace($search['content'], $replace['content'], file_get_contents($content));
            } else {
                $content = file_get_contents($content);
            }

            /**
             * @todo replace with func to create folders and files (lv helper)
             */
            file_put_contents("$destination_dir/{$destination}{$file}", $content);
        }
    }

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
