<?php
namespace Yepwoo\Laragine\Commands;
use Illuminate\Console\Command;

class MakeModule extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laragine:make-module {names}';

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
        $names = $this->argument('names');
        switch (makeModules($names)) {
            case 'done':
                $this->info('Module created');
                break;
            case 'created before':
                $this->info('Module created before');
                break;
            default:
                $this->info("Error... please try again");
        }
    }

}
