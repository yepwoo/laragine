<?php

namespace Yepwoo\Laragine\Tests;

use PHPUnit\Runner\BeforeFirstTestHook;
use PHPUnit\Runner\AfterLastTestHook;
use Illuminate\Support\Facades\File;

final class Extension implements BeforeFirstTestHook, AfterLastTestHook
{
    /**
     * called before the first test is being run
     */
    public function executeBeforeFirstTest(): void
    {
        //
    }

    /**
     * called after the last test has been run
     */
    public function executeAfterLastTest(): void
    {
        /**
         * $root_dir assigned that way as config() can't be read from here
         * 
         * @todo read root dir from the config directly
         */
        $root_dir = base_path() . '/core';
        File::deleteDirectory($root_dir);
    }
}