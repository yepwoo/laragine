<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Yepwoo\Laragine\Tests\TestCase;
use Yepwoo\Laragine\Logic\FileManipulator;

class MakeUnitTest extends TestCase
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

    // this should be in module test as the module already there
    // public function test_the_unit_command_create_basic_files_init_case_in_specified_module_case_module_not_exist()
    // {
    //     $command = $this->artisan("laragine:unit $this->unit --module=$this->module --init");
    //     $command->expectsOutput('Please create the module first');
    //     $command->assertExitCode(-1);
    // }

    // public function test_the_unit_command_without_init_option_in_case_run_init_option_at_first_in_specified_module()
    // {
    //     $command = $this->artisan("laragine:unit $this->unit --module=$this->module");
    //     $command->expectsOutput("Please type --init at the end of the command");
    // }

    public function test_the_unit_command_init_case_in_specified_module()
    {
        $this->artisan("laragine:unit $this->unit --module=$this->module --init");
        $files = config('laragine.module.unit_main_folders');
        $exist = true;
        foreach ($files as $name => $path) {
            if(!FileManipulator::exists($this->module_dir.'/'.$path.'/'.str_replace("Unit", "$this->unit", $name)))
                $exist = false;
        }
        $this->assertTrue($exist);
    }

    public function test_the_unit_command_repeat_init_case_in_specified_module()
    {
        $command = $this->artisan("laragine:unit $this->unit --module=$this->module --init");
        $command->expectsOutput("You already ran this command before");
    }
}
