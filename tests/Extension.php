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
        $config = require __DIR__ . '/../src/config.php';
        File::deleteDirectory($config['root_dir']);
    }
}