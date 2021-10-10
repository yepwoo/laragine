<?php
namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Yepwoo\Laragine\Generators\Payloads\GeneratorInterface;
use Yepwoo\Laragine\Logic\FileManipulator;

class Install implements GeneratorInterface
{
    /**
     * run the logic
     * 
     * @return string[]
     */
    public function run()
    {
        FileManipulator::generate_2(
            __DIR__ . '/../Core/Base',
            config('laragine.root_dir') . '/Base',
            config('laragine.base'),
            [
                'file' => ['stub'],
            ],
            [
                'file' => ['php'],
            ]
        );
    }
}
