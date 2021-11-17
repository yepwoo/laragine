<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Yepwoo\Laragine\Tests\TestCase;
use Yepwoo\Laragine\Logic\FileManipulator;

class InstallTest extends TestCase
{
    public function test_the_install_command_create_root_directory()
    {
        $this->artisan('laragine:install');
        $this->assertTrue(FileManipulator::exists($this->root_dir));
    }

    public function test_when_root_directory_exists_users_can_choose_to_override_it()
    {
        $command = $this->artisan('laragine:install');

        $command->expectsConfirmation(
            __('laragine::install.root_dir_exists'), 'yes'
        );

        $command->expectsOutput(__('laragine::install.success'));
    }

    public function test_when_root_directory_exists_users_can_choose_to_not_override_it()
    {
        $command = $this->artisan('laragine:install');

        $command->expectsConfirmation(
            __('laragine::install.root_dir_exists'), 'no'
        );

        $command->expectsOutput(__('laragine::install.root_dir_not_overwritten'));
    }

}
