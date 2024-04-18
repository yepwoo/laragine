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
        if (FileManipulator::exists($this->root_dir)) {
            if ($this->command->confirm(__('laragine::install.already_installed'), true)) {
                $allow_publish = true;
            } else {
                $allow_publish = false;
                $this->command->warn(__('laragine::install.root_dir_not_overwritten'));
            }
        }

        if ($allow_publish) {
            $this->publishRootDirectory();

            FileManipulator::generateDir($this->plugins_dir);
        }
    }

    /**
     * publish root directory
     * 
     * @return void
     */
    protected function publishRootDirectory() {
        FileManipulator::generate(
            __DIR__ . '/../../../Core/Base',
            $this->root_dir . '/Base',
            config('laragine.base'),
            [
                'file' => ['stub'],
            ],
            [
                'file' => ['php'],
            ]
        );
    
        $this->command->info(__('laragine::install.success'));
    } 
}

