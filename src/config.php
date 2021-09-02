<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The Base
    |--------------------------------------------------------------------------
    |
    | The stubs and files for the Base Module
    |
    */

    'base' => [
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
        '.gitignore'                 => 'views',
        'ModuleServiceProvider.stub' => 'ModuleServiceProvider.php'
    ],

];
