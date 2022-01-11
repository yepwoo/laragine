<?php

namespace Yepwoo\Laragine\Tests\Unit\Processors;

use Yepwoo\Laragine\Tests\TestCase;
use Yepwoo\Laragine\Logic\StringManipulator;
use Illuminate\Support\Facades\File;

class ProcessorTestCase extends TestCase
{
    /**
     * the module collection
     *
     * @var string[]
     */
    protected $module_collection;

    /**
     * the unit collection
     *
     * @var string[]
     */
    protected $unit_collection;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->module            = 'Module';
        $this->unit              = 'Unit';
        $this->module_dir        = $this->root_dir. '/' . $this->module;
        $this->module_collection = StringManipulator::generate($this->module);
        $this->unit_collection   = StringManipulator::generate($this->unit);

        $this->artisan("laragine:module $this->module");
        $this->artisan("laragine:unit $this->unit --module=$this->module --init");

        $data = [
            'attributes' => [
                'name'                  => ['type' => 'string', 'definition' => 'default:test2'],
                'email'                 => ['type' => 'string', 'definition' => 'unique|nullable'],
                'type'                  => ['type' => 'char:8', 'definition' => 'unique|nullable'],
                'image_url'             => ['type'   => 'string', 'definition' => 'unique|nullable'],
                'phone'                 => ['type'   => 'string', 'definition' => 'nullable'],
                'enum_str'              => ['type'   => 'enum:1,2,3'],
                'morph_text'            => ['type'   => 'morphs'],
                'nullable_morph_test'   => ['type'   => 'nullableMorphs']
            ]
        ];

        $this->overrideDataFile($data);

        $this->artisan("laragine:unit $this->unit --module=$this->module");
    }

    /**
     * run after each test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        File::deleteDirectory($this->module_dir);
    }
}
