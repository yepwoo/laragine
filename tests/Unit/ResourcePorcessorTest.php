<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Yepwoo\Laragine\Logic\StringManipulator;
use Yepwoo\Laragine\Processors\ResourceProcessor;
use Yepwoo\Laragine\Tests\TestCase;

class ResourcePorcessorTest extends TestCase
{
    public function test_output_str()
    {
        $this->artisan('laragine:module test5');

        $data['attributes'] = [
            'name'   => ['type' => 'string', 'definition' => 'default:test1'],
            'email'  => ['type' => 'string', 'definition' => 'unique|nullable'],
        ];

        $this->overrideDataFile($data);

        $module_collection = StringManipulator::generate($this->module);
        $unit_collection   = StringManipulator::generate($this->unit);

        $migration_processor_obj = new ResourceProcessor($this->module_dir, $module_collection, $unit_collection);
        $output_str = $migration_processor_obj->process();
        $expected_str = <<<STR
                                    'name' => \$this->name,
                                    'email' => \$this->email,
                        STR;
        $expected_str = preg_replace("/\r/", "", $expected_str);
        $this->assertEquals($expected_str, $output_str);
    }
}
