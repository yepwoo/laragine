<?php

namespace Yepwoo\Laragine\Logic;

use Illuminate\Support\Str;

class StringManipulator
{
    /**
     * get all possible shapes of a string
     *
     * @param  string $string
     * @return string[]
     */
    static public function generate(string $string): array
    {
        $studly   = Str::studly($string);
        $singular = Str::singular($studly);
        $plural   = Str::plural($studly);

        return [
            'studly'              => $studly,
            'singular'            => $singular,
            'plural'              => $plural,
            'singular_lower_case' => Str::lower($singular),
            'plural_lower_case'   => Str::lower($plural)
        ];
    }

    /**
     * Check if string contains : symbol
     *
     * @param $string
     * @return bool
     */
    static public function containsDots($string): bool
    {
        return strpos($string, ":") !== false;
    }

    /**
     * Convert string to arr
     *
     * @param $string
     * @param $separator
     * @return array
     */
    static public function toArray($string, $separator): array
    {
       return explode($separator, $string);
    }
}
