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
        $allow_publish = true;
        if (FileManipulator::exists(config('laragine.root_dir'))) {
            if ($this->command->confirm('The root directory already exists, do you want to override it?', true)) {
                $allow_publish = true;
            } else {
                $allow_publish = false;
                $this->command->warn('Existing root directory was not overwritten');
            }
        }

        if ($allow_publish) {
            $this->publishRootDirectory();
        }
    }

    /**
     * publish root directory
     * 
     * @return void
     */
    protected function publishRootDirectory() {
        FileManipulator::generate_2(
            __DIR__ . '/../../../Core/Base',
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

