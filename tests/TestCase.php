<?php

namespace Yepwoo\Laragine\Tests;

use Yepwoo\Laragine\Logic\FileManipulator;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * the module directory
     *
     * @var string
     */
    protected $module_dir;

    /**
     * the module directory
     *
     * @var string
     */
    protected $module;

    /**
     * the unit directory
     *
     * @var string
     */
    protected $unit;

    /**
     * the root directory
     *
     * @var string
     */
    protected $root_dir;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->module     = 'Blog';
        $this->unit       = 'Post';
        $this->root_dir   = config('laragine.root_dir');
        $this->module_dir = $this->root_dir. '/' . $this->module;
    }

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

    /**
     * get the data file for the unit
     */
    protected function getDataFile() : array
    {
        return FileManipulator::readJson("$this->module_dir/data/$this->unit.json");
    }

    /**
     * override the data file for the unit
     * 
     * @param array $array
     */
    protected function overrideDataFile($array) : void
    {
        file_put_contents("$this->module_dir/data/$this->unit.json", json_encode($array));
    }
}