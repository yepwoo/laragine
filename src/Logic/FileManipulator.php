<?php

namespace Yepwoo\Laragine\Logic;

use Illuminate\Support\Facades\File;
use stdClass;

class FileManipulator
{
    /**
     * generate the files
     *
     * @param  string   $source_dir
     * @param  string   $destination_dir
     * @param  string[] $files
     * @param  string[] $search  str_replace first param
     * @param  string[] $replace str_replace second param
     */
    public static function generate($source_dir, $destination_dir, $files, $search = [], $replace = []) : void
    {
        foreach ($files as $name => $destination) {
            $file      = $name;
            $full_path = $source_dir . '/' .$file;
            $content   = '';

            if (strpos($destination, '*') !== false) {
                $file        = '';
                $destination = substr($destination, 0, strrpos($destination, '*'));
            } else {
                if (strpos($destination, '.') !== false) {
                    if (strpos($destination, '/') !== false) {
                        $file        = substr($destination, strrpos($destination, '/') + 1);
                        $destination = substr($destination, 0, strrpos($destination, '/')) . '/';
                    } else {
                        $file        = $destination;
                        $destination = '';
                    }
                }

                if (isset($search['file']) && isset($replace['file'])) {
                    $file = str_replace($search['file'], $replace['file'], $file);
                }

                if (isset($search['content']) && isset($replace['content'])) {
                    $content = str_replace($search['content'], $replace['content'], file_get_contents($full_path));
                } else {
                    $content = file_get_contents($full_path);
                }
            }

            File::makeDirectory("$destination_dir/{$destination}", $mode = 0775, true, true);
            if ($file == '') {
                File::copyDirectory("$source_dir/{$destination}", "$destination_dir/{$destination}");
            } else if(array_key_exists('content', $replace)) {
                $unit = $replace['content'][1]; // plural lower case

                if (strpos($destination, 'Migrations') !== false) {
                    $full_destination = "$destination_dir/{$destination}";
                    self::deleteFilesWithMatchSpecificPrefix($full_destination, "create_$unit"."_"."table");

                }
                file_put_contents("$destination_dir/{$destination}{$file}", $content);
            } else {
                file_put_contents("$destination_dir/{$destination}{$file}", $content);
            }
        }
    }

    protected static function deleteFilesWithMatchSpecificPrefix($destination, $prefix) {
        foreach (glob("$destination".'/*') as $migration_file) {
            if(strpos($migration_file, $prefix) !== false) {
                File::delete("$migration_file");
            }
        }
    }
    /**
     * get the schema
     *
     * @param  string $path
     * @return object
     */
    public static function getSchema($path = __DIR__ . '/schema.json')
    {
        $integers_path = __DIR__ . '/schema/integer.json';
        $json_path     = __DIR__ . '/schema/json.json';
        $morph_path    = __DIR__ . '/schema/morph.json';
        $other_path    = __DIR__ . '/schema/other.json';
        $shape_path    = __DIR__ . '/schema/shape.json';
        $string_path   = __DIR__ . '/schema/string.json';
        $time_path     = __DIR__ . '/schema/time.json';
        $definitions   = __DIR__ .'/schema/definitions.json';


        $integers    = self::readJson($integers_path);
        $json        = self::readJson($json_path);
        $morph       = self::readJson($morph_path);
        $other       = self::readJson($other_path);
        $shape       = self::readJson($shape_path);
        $string      = self::readJson($string_path);
        $time        = self::readJson($time_path);
        $schema      = self::readJson($path);
        $definitions = self::readJson($definitions);

        $object = new stdClass();
        $object->types = (object) array_merge(
            (array) $integers,
            (array) $json,
            (array) $morph,
            (array) $other,
            (array) $shape,
            (array) $string,
            (array) $time,
        );
        $object->definitions = $definitions;
        return $object;
    }

    /**
     * read json file
     *
     * @param  string $path
     */
    public static function readJson($path) : array
    {
        $json = file_get_contents($path);
        return json_decode($json, true);
    }

    /**
     * check if dir/file exists
     *
     * @param  string $path
     */
    public static function exists($path) : bool
    {
        return File::exists($path);
    }
}
