<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Illuminate\Support\Facades\File;
use Yepwoo\Laragine\Tests\TestCase;

class InstallLaragineTest extends TestCase
{
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
        $this->root_dir = config('laragine.root_dir');
    }

    public function test_the_install_command_create_root_directory()
    {
        $this->artisan('laragine:install');
        $this->assertTrue(File::exists($this->root_dir));
    }

    public function test_when_root_directory_exists_users_can_choose_to_override_it()
    {
        $command = $this->artisan('laragine:install');

        $command->expectsConfirmation(
            'The root directory already exists, do you want to override it?', 'yes'
        );

        $command->expectsOutput('The installation done successfully!');
    }

    public function test_when_root_directory_exists_users_can_choose_to_not_override_it()
    {
        $command = $this->artisan('laragine:install');

        $command->expectsConfirmation(
            'The root directory already exists, do you want to override it?', 'no'
        );

        $command->expectsOutput('Existing root directory was not overwritten');
    }

}
