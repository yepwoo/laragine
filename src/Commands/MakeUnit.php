<?php

namespace Yepwoo\Laragine\Commands;

use Illuminate\Console\Command;

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
        $name              = $this->argument('name');
        $module            = $this->option('module');
        $create_unit_files = null;

        if ($this->option('init')) {
            $create_unit_files = createUnitFiles($name, $module, true);
        } else {
            $create_unit_files = createUnitFiles($name, $module);
        }
        switch ($create_unit_files) {
            case 'done':
                $this->info('Unit created successfully');
                break;
            case 'nullable module':
                $this->error('module option is required');
                break;
            case 'unit exist':
                $this->error("$name is already exist");
                break;
            case 'ordering error':
                $this->error("Ordering error in your json file In attributes, please write type first then mod");
                break;
            case 'mod syntax error':
                $this->error("Syntax error, check the mod key");
                break;
            case 'single type have value error':
                $this->error("Single type shouldn't contain ':', please remove it");
                break;
            case 'rerun init command':
                $this->error("You're ran init command before :)");
                break;
            case 'must run init command':
                $this->error("Please run init command first");
                break;
            case 'module_not_exist':
                $this->error("Please run `laragine:module $module` first");
                break;
            case 'undefined type':
                $this->error("Undefined type!, please sure this is a right type");
                break;
            default:
                $this->error("Error... please try again");
        }
    }
}
