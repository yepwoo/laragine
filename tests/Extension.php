<?php

namespace Yepwoo\Laragine\Tests;

use PHPUnit\Runner\Extension\Extension as PhpUnitExtension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;

final class Extension implements PhpUnitExtension
{
    /**
     * register the subscribers that react to the test runner's events
     */
    public function bootstrap(
        Configuration $configuration,
        Facade $facade,
        ParameterCollection $parameters
    ): void {
        $facade->registerSubscriber(new CleanUpGeneratedFiles());
    }
}
