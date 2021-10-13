<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use phpDocumentor\Reflection\Types\Parent_;
use Yepwoo\Laragine\Tests\TestCase;

class MakeModuleTest extends TestCase
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
        $this->root_dir   = config('laragine.root_dir');
        $this->module_dir = $this->root_dir. '/' . $this->module;
    }

    public function test_the_module_command_create_module_directory()
    {
        // assume that we run install command to enure that core directory is exists
        if(!File::isDirectory($this->root_dir)) {
            Artisan::call('laragine:install');
        }

        // make sure we're starting from a clean state
        if(File::exists($this->module_dir)) {
            File::deleteDirectory($this->module_dir);
        }

        Artisan::call("laragine:module $this->module");
        $this->assertTrue(File::exists($this->module_dir));
    }

    public function test_when_module_directory_exists_users_can_choose_to_override_it()
    {
        // assume that we run install command to enure that core directory is exists
        if(!File::isDirectory($this->root_dir)) {
            Artisan::call('laragine:install');
        }

        if(!File::isDirectory($this->module_dir)) {
            Artisan::call("laragine:module $this->module");
        }
        $command = $this->artisan("laragine:module $this->module");

        $command->expectsConfirmation(
            'The root directory already exists, do you want to override it?', 'yes'
        );

        $command->expectsOutput('Module created successfully!');

    }
//
    public function test_when_module_directory_exists_users_can_choose_to_not_override_it()
    {
        // assume that we run install command to enure that core directory is exists
        if(!File::isDirectory($this->root_dir)) {
            Artisan::call('laragine:install');
        }

        if(!File::exists($this->module_dir)) {
            Artisan::call("laragine:module $this->module");
        }

        $command = $this->artisan("laragine:module $this->module");

        $command->expectsConfirmation(
            'The root directory already exists, do you want to override it?', 'no'
        );

        $command->expectsOutput('Existing module directory was not overwritten');
    }
    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        Parent::tearDown();

        // clean up
        File::deleteDirectory($this->root_dir);
    }
}
