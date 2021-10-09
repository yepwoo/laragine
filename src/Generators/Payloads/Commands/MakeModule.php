<?php
namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Illuminate\Support\Str;
use Yepwoo\Laragine\Generators\Payloads\GeneratorInterface;
use Yepwoo\Laragine\Helpers\Attributes;
use Yepwoo\Laragine\Logic\FileManipulator;
use Yepwoo\Laragine\Logic\StringManipulator;

class MakeModule extends Attributes implements GeneratorInterface {

    protected $config;
    protected $module_collection;
    public function __construct($object = null)
    {

        $this->config['main_files'] = config('laragine.module.main_files');
        $this->config['unit_folders'] = config('laragine.module.unit_folders');
        $this->module_collection = StringManipulator::generate($object['module']);
        if(!$this->createModuleFolder())
        {
            $this->callback = 'created before';
        }

        // $this->createFolders();
        $this->createFiles();

    }
    public function createFolders()
    {
        foreach ($this->config['unit_folders'] as $key => $folder) {
            if(!folder_exist('base_path', "core/".$this->module_collection['studly']."/$folder")) {
                mkdir(base_path("core/".$this->module_collection['studly']."/$folder"), 0777, true);
            }
        }
    }

    public function createFiles()
    {
        $source_dir      = __DIR__ . '/../../../Core/Module';
        $destination_dir = config('laragine.root_dir') . '/'. $this->module_collection['studly'];
        $files           = $this->config['main_files'];
        
        // $stubs_vars    = ["#UNIT_NAME#", "#UNIT_NAME_PLURAL_LOWER_CASE#", "#UNIT_NAME_LOWER_CASE#", "#MODULE_NAME#"];
        $repalce =  [
                        $this->module_collection['studly'], 
                        $this->module_collection['plural_lower_case'], 
                        $this->module_collection['singular_lower_case'],
                        $this->module_collection['studly']
        ];

        $search = 
        [
            'file'    => ['stub'],
            'content' => ["#UNIT_NAME#", "#UNIT_NAME_PLURAL_LOWER_CASE#", "#UNIT_NAME_LOWER_CASE#", "#MODULE_NAME#"]
        ];

        $repalce = 
        [
            'file'    => ['php'],
            'content' => $repalce
        ];

        FileManipulator::generate_2($source_dir, $destination_dir, $files, $search, $repalce);

        // foreach ($this->config['main_files'] as $key => $file) {
        //     $folder = substr($file, 0,strrpos($file, '/'));

        //     if(!folder_exist('base_path', "core/".$this->module_collection['studly']."/$folder")) {
        //         mkdir(base_path("core/".$this->module_collection['studly']."/$folder"), 0777, true);
        //     }
        //     $stubs_vars    = ["#UNIT_NAME#", "#UNIT_NAME_PLURAL_LOWER_CASE#", "#UNIT_NAME_LOWER_CASE#", "#MODULE_NAME#"];

        //     $path = base_path() . '\\core'."\\".$this->module_collection['singular']."\\$file";
        //     FileManipulator::generate($key, $stubs_vars, $this->module_collection, $path);
        // }
    }

    function createModuleFolder(): bool
    {
        if(folder_exist('base_path', "core/".$this->module_collection['studly'])) {
            return false;
        }
        // create module folder
        mkdir(base_path() . "/core/".$this->module_collection['studly'], 0777, true);
        return true;
    }
}
