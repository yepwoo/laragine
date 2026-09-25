<?php

namespace Yepwoo\Laragine\Tests;

use Illuminate\Support\Facades\File;
use PHPUnit\Event\TestRunner\ExecutionFinished;
use PHPUnit\Event\TestRunner\ExecutionFinishedSubscriber;

/**
 * The tests generate real directories on disk. Remove them once the whole
 * suite has finished, so a run leaves the working tree as it found it.
 */
final class CleanUpGeneratedFiles implements ExecutionFinishedSubscriber
{
    public function notify(ExecutionFinished $event): void
    {
        $config = require __DIR__ . '/../src/config.php';

        File::deleteDirectory($config['root_dir']);
        File::deleteDirectory($config['plugins_dir']);
    }
}
