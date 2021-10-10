<?php
namespace Yepwoo\Laragine\Commands;
use Illuminate\Console\Command;
use Yepwoo\Laragine\Generators\Payloads\GeneratorFactory;

class MakeModule extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laragine:module {name}';

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

        $validatorFactory = \Yepwoo\Laragine\Logic\Validators\ValidatorFactory::create('module', $name);
        $callback = $validatorFactory->valid();
        
        switch ($callback['flag']) {
            case 'error':
                $this->{$callback['flag']}($callback['msg']);
                break;
            case 'info' :
                $module = GeneratorFactory::create('MakeModule', $name);
                $this->{$callback['flag']}($callback['msg']);
                break;
            case 'confirm':
                if ($this->confirm($callback['msg'], true)) {
                    $module = GeneratorFactory::create('MakeModule', $name);
                    $this->info("Done...");
                }
                break;
        }
        exit;
        $module = GeneratorFactory::create('MakeModule', $name);
        switch ($module->callback) {
            case 'done':
                $this->info('Module created');
                break;
            case 'created before':
                $this->error('Module created before');
                break;
            default:
                $this->error("Error... please try again");
        }
    }

}
