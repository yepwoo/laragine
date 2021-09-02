<?php

namespace Yepwoo\Laragine\Helpers;

class BaseHelpers {
    public static function getCoreStubs() {

    }

    public static function MainFolders(): array
    {
        return [
            'Config',
            'Controllers',
            'Controllers/API',
            'Controllers/Web',
            'Logging',
            'Middleware',
            'Models',
            'Routes',
            'Tests',
            'Traits',
            'Views'
        ];
    }

    public static function CreateFolders() {
        $main_path = app_path().'/Core';
        if(!folder_exist('app_path', 'Core'))
            mkdir("$main_path", 0777, true);

        if(!folder_exist('app_path', 'Core/Base'))
            mkdir("$main_path/Base", 0777, true);

        foreach (self::MainFolders() as $name) {
            if(!folder_exist('app_path', "Core/Base/$name"))
                mkdir("$main_path/Base/$name", 0777, true);
        }
    }
}
