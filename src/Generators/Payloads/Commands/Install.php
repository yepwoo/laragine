<?php
namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Yepwoo\Laragine\Logic\FileManipulator;

class Install extends Base
{
    /**
     * run the logic
     * 
     * @return void
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

        $this->command->info('The installation done successfully!');
    }
}
