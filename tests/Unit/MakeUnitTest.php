<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Yepwoo\Laragine\Tests\TestCase;
use Yepwoo\Laragine\Logic\FileManipulator;

class MakeUnitTest extends TestCase
{
    public function test_the_unit_command_without_init_option_in_case_run_init_option_at_first_in_specified_module()
    {
        $command = $this->artisan("laragine:unit $this->unit --module=$this->module");
        $command->expectsOutput(__('laragine::unit.init_not_executed'));
    }

    public function test_the_unit_command_init_case_in_specified_module()
    {
        $command = $this->artisan("laragine:unit $this->unit --module=$this->module --init");
        $command->expectsOutput(__('laragine::unit.success_init_executed'));
    }

    public function test_the_unit_command_repeat_init_case_in_specified_module()
    {
        $command = $this->artisan("laragine:unit $this->unit --module=$this->module --init");
        $command->expectsOutput(__('laragine::unit.init_executed'));
    }
}
