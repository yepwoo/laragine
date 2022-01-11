<?php

namespace Yepwoo\Laragine\Tests\Unit\Processors;

use Yepwoo\Laragine\Processors\ResourceProcessor;

class ResourceProcessorTest extends ProcessorTestCase
{
    public function test_output_str()
    {
        $resource_processor_obj = new ResourceProcessor($this->module_dir, $this->module_collection, $this->unit_collection);
        $output_str = $resource_processor_obj->process();
        $expected_str = <<<STR
                                    'name' => \$this->name,
                                    'email' => \$this->email,
                                    'type' => \$this->type,
                                    'image_url' => \$this->image_url,
                                    'phone' => \$this->phone,
                                    'enum_str' => \$this->enum_str,
                        
                        STR;
        $expected_str = preg_replace("/\r/", "", $expected_str);
        $this->assertEquals($expected_str, $output_str);
    }

    /**
     * @test
     */
    public function test_str_is_empty_before_concatenation()
    {
        $resource_processor_obj = new ResourceProcessor($this->module_dir, $this->module_collection, $this->unit_collection);

        $processor_str = $resource_processor_obj->getProcessorStr();

        $this->assertEmpty($processor_str);
    }

    /**
     * @test
     */
    public function test_str_is_empty_after_concatenation()
    {
        $resource_processor_obj = new ResourceProcessor($this->module_dir, $this->module_collection, $this->unit_collection);
        $resource_processor_obj->process();

        $processor_str = $resource_processor_obj->getProcessorStr();

        $this->assertNotEmpty($processor_str);
    }

    /**
     * @test
     */
    public function test_init_str()
    {
        $resource_processor_obj = new ResourceProcessor($this->module_dir, $this->module_collection, $this->unit_collection);
        $processor_str = $resource_processor_obj->getProcessorStr();
        $this->assertEmpty($processor_str);

        $resource_processor_obj->setInitStr('name');

        $processor_str = $resource_processor_obj->getProcessorStr();
        $expected_str  = <<<STR
                                    'name' => \$this->name
                        STR;
        $this->assertEquals($expected_str, $processor_str);
    }

    /**
     * @test
     */
    public function test_is_str()
    {
        $resource_processor_obj = new ResourceProcessor($this->module_dir, $this->module_collection, $this->unit_collection);
        $resource_processor_obj->setInitStr('name');

        $processor_str = $resource_processor_obj->getProcessorStr();

        $this->assertIsString($processor_str);
    }
}
