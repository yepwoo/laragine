<?php

namespace Yepwoo\Laragine\Commands;

use Illuminate\Console\Command;
use Yepwoo\Laragine\Generators\Payloads\GeneratorFactory;
use Yepwoo\Laragine\Helpers\BaseHelpers;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laragine:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Yepwoo\Laragine\Logic\FileManipulator::generate_2(
            __DIR__ . '/../Core/Base',
            config('laragine.root_dir') . '/Base',
            config('laragine.base'),
            [
                'file'    => ['stub'],
            ],
            [
                'file'    => ['php'],
            ]
        );

        $this->info('DONE');
        exit;

        // copy the Base dir into /Core
        $this->info('Installing Laragine...');
        $this->info('Publishing configuration...');
        if(!folder_exist('base_path', 'Core')) {
            $this->publishCoreFolderAndFiles();
            $this->publishViewsFoldersAndFiles();
            $this->info('Published configuration');
        } else {
            if($this->shouldOverwriteFolders()) {
                $this->info('Overwriting configuration file....');
                $this->publishCoreFolderAndFiles();
                $this->publishViewsFoldersAndFiles();
            } else {
                $this->info('Existing core was not overwritten');
            }
        }
        $this->info('The installation done successfully!');
    }

    private function publishCoreFolderAndFiles($forcePublish = false)
    {
        // here will call helper function that load all stubs file
        $payload = GeneratorFactory::create('install');
        $payload->createFolders();
        $payload->createFiles();

        /**
         * === Olding code ===
         */
//
//        BaseHelpers::createFolders();
//        BaseHelpers::createFiles();
    }

    private function shouldOverwriteFolders(): bool
    {
        return $this->confirm(
            'Core folder already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishViewsFoldersAndFiles() {
        if(BaseHelpers::createViewsFolders() == 'success') {
            BaseHelpers::createViewsFiles();
        };
    }
}
