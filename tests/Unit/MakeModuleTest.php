<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Yepwoo\Laragine\Tests\TestCase;
use Yepwoo\Laragine\Logic\FileManipulator;

class MakeModuleTest extends TestCase
{
    /**
     * will keep this test here for now (as we need to test creating the unit and there is no module created yet)
     */
    public function test_the_unit_command_create_basic_files_init_case_in_specified_module_case_module_not_exist()
    {
        $command = $this->artisan("laragine:unit $this->unit --module=$this->module --init");
        $command->expectsOutput(__('laragine::unit.module_missing'));
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
