<?php

namespace Yepwoo\Laragine\Helpers;

class BaseHelpers {
    /**
     * Create all core folders
     */
    public static function createFolders() {
        $files = config('laragine.base');

        $main_path = base_path().'/core';
        if (!folder_exist('base_path', 'core')) {
            mkdir("$main_path", 0777, true);
        }

        if (!folder_exist('base_path', 'core/Base')) {
            mkdir("$main_path/Base", 0777, true);
        }

        foreach ($files as  $name) {
            $file = substr($name, 0,strrpos($name, '/'));
            if (!folder_exist('base_path', "core/Base/$file")) {
                mkdir("$main_path/Base/$file", 0777, true);
            }
        }
    }

    /**
     * Create all core files
     */
    public static function createFiles() {

        // temporary until how to load files from config
        $files = config('laragine.base');
        foreach ($files as $key => $file) {
            $main_path = 'core\Base\\';
            $temp = getStub(__DIR__ . '/../'.$main_path . $key);
            file_put_contents(base_path() . '\\' .$main_path."$file", $temp);
        }
    }
}
