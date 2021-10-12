<?php

namespace Yepwoo\Laragine\Tests;

// use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
// use Orchestra\Testbench\Concerns\CreatesApplication;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'Yepwoo\Laragine\ModuleServiceProvider',
        ];
    }

}