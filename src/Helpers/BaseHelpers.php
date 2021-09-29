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

    public static function createViewsFolders(): string
    {
        $folders = config('laragine.main_views');
        $main_path = base_path().'/core/Base';
        foreach ($folders as $folder => $files) {
            if (!folder_exist('base_path', "core/Base/views/$folder")) {
                mkdir("$main_path/views/$folder", 0777, true);
            }
        }
        /**
         * == Create unit_template folder ====
         */
        if (!folder_exist('base_path', "core/Base/unit_template")) {
            mkdir("$main_path/unit_template", 0777, true);
        }
        return 'success';
    }

    public static function createViewsFiles() {
        $folders = config('laragine.main_views');
        $main_path = base_path().'/core/Base';

        /**
         * === Main folders ===
         */
        foreach ($folders as $folder => $files) {
            foreach ($files as $file) {
                $destination = $main_path . "/views/" . $folder . "/$file";
                $source     = __DIR__ . '/../'.'Core/Base/views/' . $folder . '/' . $file;
                $data = file_get_contents($source);
                file_put_contents($destination, $data);
            }
        }

        /**
         * ==== Unit templates files ====
         * index - create - update - show - form
         */

        foreach (glob( __DIR__ . '/../'.'Core/Base/unit_template/*.php') as $file_path) {
            $file_name = pathinfo($file_path);
            $destination = $main_path . "/" . "unit_template/". $file_name['basename'];
            $data = file_get_contents($file_path);
            file_put_contents($destination, $data);
        }
    }
}
