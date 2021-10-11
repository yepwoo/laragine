<?php

namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Yepwoo\Laragine\Generators\Payloads\GeneratorInterface;
use Illuminate\Console\Command;

class Base implements GeneratorInterface 
{
    /**
     * related command
     * 
     * @var Command
     */
    protected $command;

    /**
     * all the args passed
     * 
     * @var array
     */
    protected $args;
    
    /**
     * init
     * 
     * @param  Command $command
     * @param  array $args
     * @return void
     */
    public function __construct(Command $command, $args)
    {
        $this->command = $command;
        $this->args    = $args;
    }
}