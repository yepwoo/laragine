<?php
namespace Yepwoo\Laragine\Commands;
use Illuminate\Console\Command;

class MakeUnit extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lara:make:unit {name} {--module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle() {
        $name = $this->argument('name');
        $module = $this->option('module');

        ;
        switch (createUnitFiles($name, $module)) {
            case 'done':
                $this->info('Unit created successfully');
                break;
            case 'nullable module':
                $this->info('module option is required');
                break;
            case 'unit exist':
                $this->info("$name is already exist");
                break;
            default:
                $this->info("Error... please try again");
        }
    }

}