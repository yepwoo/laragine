<?php

namespace Yepwoo\Laragine\Tests\Unit\Processors;

use Yepwoo\Laragine\Processors\FactoryProcessor;

class FactoryProcessorTest extends ProcessorTestCase
{
    public function test_output_str()
    {
        $processor    = new FactoryProcessor($this->module_dir, $this->module_collection, $this->unit_collection);
        $output_str   = $processor->process();
        $expected_str = <<<STR
                                    'name' => \$this->faker->text(100),
                                    'email' => \$this->faker->unique()->safeEmail(),
                                    'type' => \$this->faker->unique()->word(),
                                    'image_url' => \$this->faker->unique()->url(),
                                    'phone' => \$this->faker->phoneNumber(),
                                    'enum_str' => '',
                        STR;
        $expected_str = preg_replace("/\r/", "", $expected_str);
        $this->assertEquals($expected_str, $output_str);
    }
}
