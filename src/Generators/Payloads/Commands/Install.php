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
        $path = base_path('core');
        if (FileManipulator::exists($path)) {
            if (!$this->command->confirm("The core folder already exists, do you want to override it?", true)) {
                $this->command->info("Existing core folder was not overwritten");
                
            } else {
                $this->publistCoreFolder();
            }
        } else {
            $this->publistCoreFolder();
        }
    }
    public function publistCoreFolder() {
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

