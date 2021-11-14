<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Yepwoo\Laragine\Tests\TestCase;
use Yepwoo\Laragine\Logic\FileManipulator;

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
        $this->artisan("laragine:module $this->module");
        $this->assertTrue(FileManipulator::exists($this->module_dir));
    }

    public function test_when_module_directory_exists_users_can_choose_to_override_it()
    {
        $command = $this->artisan("laragine:module $this->module");

        $command->expectsConfirmation(
            __('laragine::module.exists'), 'yes'
        );

        $command->expectsOutput(__('laragine::module.success'));
    }

    public function test_when_module_directory_exists_users_can_choose_to_not_override_it()
    {
        $command = $this->artisan("laragine:module $this->module");

        $command->expectsConfirmation(
            __('laragine::module.exists'), 'no'
        );

        $command->expectsOutput(__('laragine::module.not_overwritten'));
    }
}
