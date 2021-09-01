<?php

namespace Yepwoo\Laragine\Commands;

use Illuminate\Console\Command;

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
        // copy the Base dir into /Core
        $this->info('Installing Laragine...');

        $this->info('Publishing configuration...');

        if(! folder_exist('app_path', 'Core')) {
            $this->publishCoreFolder();
            $this->info('Published configuration');
        } else {
            if($this->shouldOverwriteFolders()) {
                $this->info('Overwriting configuration file....');
                $this->publishCoreFolder();
            } else {
                $this->info('Existing core was not overwritten');
            }
        }
        $this->info('The installation done successfully!');
    }

    private function publishCoreFolder($forcePublish = false)
    {
        // here will call helper function that load all stubs file
    }

    private function shouldOverwriteFolders(): bool
    {
        return $this->confirm(
            'Core folder already exists. Do you want to overwrite it?',
            false
        );
    }
}
