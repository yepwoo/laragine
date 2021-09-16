<?php
namespace Yepwoo\Laragine\Commands;
use Illuminate\Console\Command;
use Yepwoo\Laragine\Helpers\AttributeHelpers;

class MakeAttributes extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laragine:make:attribute {--module=} {--unit=} {--attributes=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new attributes';

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
        $unit = $this->option('unit');
        $module = $this->option('module');

        AttributeHelpers::workOnFile($module, $unit);
//        switch (createUnitFiles($name, $module)) {
//            case 'done':
//                $this->info('Unit created successfully');
//                break;
//            case 'nullable module':
//                $this->info('module option is required');
//                break;
//            case 'unit exist':
//                $this->info("$name is already exist");
//                break;
//            default:
//                $this->info("Error... please try again");
//        }
    }

}
