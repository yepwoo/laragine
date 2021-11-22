<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Yepwoo\Laragine\Logic\StringManipulator;
use Yepwoo\Laragine\Processors\FactoryProcessor;
use Yepwoo\Laragine\Processors\Processor;
use Yepwoo\Laragine\Tests\TestCase;

class FactoryProcessortTest extends TestCase
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

    /**
     * @test
     */
    public function test_output_str()
    {
        $this->artisan("laragine:module test3");

        $data['attributes'] = [
            'name'       => ['type'   => 'string', 'definition' => 'default:test2'],
            'email'      => ['type'   => 'char:8', 'definition' => 'unique|nullable'],
            'image_url'  => ['type'   => 'string', 'definition' => 'unique|nullable'],
            'phone'      => ['type'   => 'string', 'definition' => 'nullable'],

        ];

        $this->overrideDataFile($data);

        $module_collection = StringManipulator::generate($this->module);
        $unit_collection   = StringManipulator::generate($this->unit);

        $migration_processor_obj = new FactoryProcessor($this->module_dir, $module_collection, $unit_collection);
        $output_str              = $migration_processor_obj->process();
        $expected_str = <<<STR
                                    'name' => \$this->faker->text(100),
                                    'email' => \$this->faker->unique()->word(),
                                    'image_url' => \$this->faker->unique()->url(),
                                    'phone' => \$this->faker->phoneNumber(),
                        STR;
        $expected_str = preg_replace("/\r/", "", $expected_str);
        $this->assertEquals($expected_str, $output_str);
    }


}
