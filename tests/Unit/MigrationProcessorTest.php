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
        $data['attributes'] = [
            'name'   => ['type' => 'string', 'definition' => 'default:test'],
            'email'  => ['type' => 'string', 'definition' => 'unique|nullable'],
        ];

        $this->overrideDataFile($data);

        $module_collection = StringManipulator::generate($this->module);
        $unit_collection   = StringManipulator::generate($this->unit);

        $migration_processor_obj = new MigrationProcessor($this->module_dir, $module_collection, $unit_collection);
        $output_str = $migration_processor_obj->process();

        $expected_str = '
            $table->string("name")->default("test");
            $table->string("email")->unique()->nullable();
        ';
        $this->assertEquals($expected_str, $output_str);
    }
}
