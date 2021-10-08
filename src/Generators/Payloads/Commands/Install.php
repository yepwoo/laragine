<?php
namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Yepwoo\Laragine\Generators\Payloads\GeneratorInterface;

class Install implements GeneratorInterface {

    protected $files;
    public function __construct($object = null) {
        $this->files = config('laragine.base');
    }
    public function createFolders()
    {
        $main_path = base_path().'/core';
        if (!folder_exist('base_path', 'core')) {
            mkdir("$main_path", 0777, true);
        }

        if (!folder_exist('base_path', 'core/Base')) {
            mkdir("$main_path/Base", 0777, true);
        }

        foreach ($this->files as  $name) {
            $file = substr($name, 0,strrpos($name, '/'));
            if (!folder_exist('base_path', "core/Base/$file")) {
                mkdir("$main_path/Base/$file", 0777, true);
            }
        }
    }

    public function createFiles()
    {
        // TODO: Implement createFiles() method.
        // temporary until how to load files from config
        foreach ($this->files as $key => $file) {
            $main_path = 'core\Base\\';
            $temp = getStub(__DIR__ . '/../../../' .$main_path . $key);
            file_put_contents(base_path() . '\\' .$main_path."$file", $temp);
        }
    }
}
