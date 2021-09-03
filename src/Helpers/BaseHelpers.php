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
            'Tests/Unit',
            'Traits/Model',
            'Traits/Response',
            'Traits/ServiceProvider',
            'Traits/Views',
            'Views'
        ];
    }

    /**
     * Create all core folders
     */
    public static function createFolders() {
        $main_path = base_path().'/Core';
        if(!folder_exist('app_path', 'Core'))
            mkdir("$main_path", 0777, true);

        if(!folder_exist('app_path', 'Core/Base'))
            mkdir("$main_path/Base", 0777, true);

        foreach (self::MainFolders() as $name) {
            if(!folder_exist('app_path', "Core/Base/$name"))
                mkdir("$main_path/Base/$name", 0777, true);
        }
    }

    /**
     * Create all core files
     */
    public static function createFiles() {

        // temporary until how to load files from config
        $files = [
            'main.php'                   => 'config/main.php',
            'ApiController.stub'         => 'Controllers/API/Controller.php',
            'WebController.stub'         => 'Controllers/Web/Controller.php',
            'CustomizeFormatter.stub'    => 'Logging/CustomizeFormatter.php',
            'CheckApiKey.stub'           => 'Middleware/CheckApiKey.php',
            'Base.stub'                  => 'Models/Base.php',
            'api.php'                    => 'routes/api.php',
            'web.php'                    => 'routes/web.php',
            'WebControllerTest.stub'     => 'Tests/Unit/WebControllerTest.php',
            'TestCase.stub'              => 'Tests/TestCase.php',
            'Uuid.stub'                  => 'Traits/Model/Uuid.php',
            'SendResponse.stub'          => 'Traits/Response/SendResponse.php',
            'File.stub'                  => 'Traits/ServiceProvider/File.php',
            'Module.stub'                => 'Traits/ServiceProvider/Module.php',
            'Path.stub'                  => 'Traits/Views/Path.php',
            'Variable.stub'              => 'Traits/Views/Variable.php',
            '.gitignore'                 => 'Views/.gitignore',
            'ModuleServiceProvider.stub' => 'ModuleServiceProvider.php'
        ];
        foreach ($files as $key => $file) {
            $main_path = 'Core\Base\\';
            $temp = getStub(__DIR__ . '/../'.$main_path . $key);
            file_put_contents(base_path() . '\\' .$main_path."$file", $temp);
        }
    }
}
