<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Yepwoo\Laragine\Logic\StringManipulator;
use Yepwoo\Laragine\Processors\MigrationProcessor;
use Yepwoo\Laragine\Tests\TestCase;

class MigrationProcessorTest extends TestCase
{
    /**
     * override the data file for the unit
     *
     * @param array $array
     */
    protected function overrideDataFile($array) : void
    {
        file_put_contents("$this->module_dir/data/$this->unit.json", json_encode($array));
    }

    public function test_output_str()
    {
        $this->artisan("laragine:module test");

        $data['attributes'] = [
            'name'   => ['type' => 'string', 'definition' => 'default:test2'],
            'email'  => ['type' => 'string', 'definition' => 'unique|nullable'],
        ];

        $this->overrideDataFile($data);

        $module_collection = StringManipulator::generate($this->module);
        $unit_collection   = StringManipulator::generate($this->unit);

        $migration_processor_obj = new MigrationProcessor($this->module_dir, $module_collection, $unit_collection);
        $output_str = $migration_processor_obj->process();
        $expected_str = <<<STR
                                    \$table->string('name')->default('test2');
                                    \$table->string('email')->unique()->nullable();
                        STR;
        $expected_str = preg_replace("/\r/", "", $expected_str);
        $this->assertEquals($expected_str, $output_str);
    }
}
