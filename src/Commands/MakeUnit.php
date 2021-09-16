<?php
namespace Yepwoo\Laragine\Commands;
use Illuminate\Console\Command;

class MakeUnit extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laragine:make-unit {name} {--module=} {--I|init}';

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
    public function handle() {
        $name              = $this->argument('name');
        $module            = $this->option('module');
        $create_unit_files = null;

        if ($this->option('init')) {
            $create_unit_files = createUnitFiles($name, $module, [
                'UnitApiController.stub',
                'UnitWebController.stub',
                'Unit.stub'
            ]);
        } else {
            $create_unit_files = createUnitFiles($name, $module);
        }

        switch ($create_unit_files) {
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
