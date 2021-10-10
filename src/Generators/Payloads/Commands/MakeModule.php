<?php
namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Yepwoo\Laragine\Generators\Payloads\GeneratorInterface;
use Yepwoo\Laragine\Logic\FileManipulator;
use Yepwoo\Laragine\Logic\StringManipulator;

class MakeModule implements GeneratorInterface 
{
    /**
     * all the args passed
     * 
     * @var array
     */
    protected $args;
    
    /**
     * init
     * 
     * @param  array $args
     * @return void
     */
    public function __construct($args)
    {
        $this->args = $args;
    }

    /**
     * run the logic
     * 
     * @return string[]
     */
    public function run()
    {
        $module_collection = StringManipulator::generate($this->args[0]);
        $source_dir        = __DIR__ . '/../../../Core/Module';
        $destination_dir   = config('laragine.root_dir') . '/'. $module_collection['studly'];
        $files             = $this->config['main_files'];

        $search = [
            'file'    => ['stub'],
            'content' => [
                "#UNIT_NAME#",
                "#UNIT_NAME_PLURAL_LOWER_CASE#",
                "#UNIT_NAME_LOWER_CASE#",
                "#MODULE_NAME#"
            ]
        ];

        $replace = [
            'file'    => ['php'],
            'content' => [
                $module_collection['studly'], 
                $module_collection['plural_lower_case'], 
                $module_collection['singular_lower_case'],
                $module_collection['studly']
            ]
        ];

        FileManipulator::generate_2($source_dir, $destination_dir, $files, $search, $replace);
    }
}
