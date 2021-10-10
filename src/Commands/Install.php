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
        $command = GeneratorFactory::create('Install');
        $command->run();
        $this->info('The installation done successfully!');
    }
}
