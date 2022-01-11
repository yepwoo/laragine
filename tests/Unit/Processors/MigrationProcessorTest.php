<?php

namespace Yepwoo\Laragine\Tests\Unit\Processors;

use Yepwoo\Laragine\Processors\MigrationProcessor;

class MigrationProcessorTest extends ProcessorTestCase
{
    public function test_output_str()
    {
        $processor    = new MigrationProcessor($this->module_dir, $this->module_collection, $this->unit_collection);
        $output_str   = $processor->process();
        $expected_str = <<<STR
                                    \$table->string('name')->default('test2');
                                    \$table->string('email')->unique()->nullable();
                                    \$table->char('type', 8)->unique()->nullable();
                                    \$table->string('image_url')->unique()->nullable();
                                    \$table->string('phone')->nullable();
                                    \$table->enum('enum_str', [1,2,3]);
                                    \$table->morphs('morph_text');
                                    \$table->nullableMorphs('nullable_morph_test');
                        STR;
        $expected_str = preg_replace("/\r/", "", $expected_str);
        $this->assertEquals($expected_str, $output_str);
    }
}
