<?php

namespace Yepwoo\Laragine\Commands;

use Illuminate\Console\Command;
use Yepwoo\Laragine\Generators\Payloads\GeneratorFactory;

class MakeUnit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laragine:unit {name} {--module=} {--I|init}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new unit';

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
        if (!$this->option('module')) {
            $this->error(__('laragine::unit.module_required'));
            return;
        }
        
        $command = GeneratorFactory::create(
            $this,
            'MakeUnit',
            $this->argument('name'),
            $this->option('module'),
            $this->option('init')
        );

        $command->run();
    }
}
