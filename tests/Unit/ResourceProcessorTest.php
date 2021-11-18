<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Yepwoo\Laragine\Tests\TestCase;
use Yepwoo\Laragine\Processors\ResourceProcessor;
use Yepwoo\Laragine\Logic\StringManipulator;

class ResourceProcessorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        /**
         * we run the following command because it throws "Target class [files] does not exist."
         * I think it's not loading laravel stuff unless explicitly doing so, so running the following command will do
         * the job (in tests/Extension.php we use Illuminate\Support\Facades\File class)
         */
        $this->artisan('laragine:module test');
    }

    public function testContentShouldBeTheSame()
    {
        $processor = new ResourceProcessor(
            $this->module_dir,
            StringManipulator::generate($this->module),
            StringManipulator::generate($this->unit)
        );

        $string = <<<STR
                   'name' => \$this->name,
       STR        ;

        $this->assertEquals($string, $processor->process());
    }
}
