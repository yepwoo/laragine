<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Illuminate\Support\Facades\File;
use Yepwoo\Laragine\Logic\FileManipulator;
use Yepwoo\Laragine\Tests\TestCase;

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

    public function test_the_unit_command_create_basic_files_init_case_in_specified_module_case_module_not_exist()
    {
        $command = $this->artisan("laragine:unit $this->unit --module=$this->module --init");
        $command->expectsOutput('Please create the module first');
        $command->assertExitCode(-1);
    }

    public function test_the_unit_command_init_case_in_specified_module()
    {
        // to ensure the module is exist
        $this->artisan("laragine:module $this->module");

        //
        $this->artisan("laragine:unit $this->unit --module=$this->module --init");
        $files             = config('laragine.module.unit_main_folders');
        $exist = 1;
        foreach ($files as $name => $path) {
            if(!FileManipulator::exists($this->module_dir.'/'.$path.'/'.str_replace("Unit", "$this->unit", $name)))
                $exist = 0;
        }
        $this->assertTrue($exist);
    }

    public function test_the_unit_command_repeat_init_case_in_specified_module()
    {
        // to ensure the module is exist
        $this->artisan("laragine:module $this->module");

        // call the command twice
        $this->artisan("laragine:unit $this->unit --module=$this->module --init");

        $command = $this->artisan("laragine:unit $this->unit --module=$this->module --init");

        $command->expectsOutput("You already ran this command before");
    }

    public function test_the_unit_command_without_call_init_case_first_in_specified_module()
    {
        // to ensure the module is exist
        $this->artisan("laragine:module $this->module");

        // call the command twice
        $command = $this->artisan("laragine:unit $this->unit --module=$this->module");

        $command->expectsOutput("Please type --init at the end of the command");
    }

    public function test_the_unit_command_without_init_option_in_case_run_init_option_at_first_in_specified_module()
    {
        // to ensure the module is exist
        $this->artisan("laragine:module $this->module");

        // call the command twice
        $command = $this->artisan("laragine:unit $this->unit --module=$this->module");

        $command->expectsOutput("Please type --init at the end of the command");
    }


}
