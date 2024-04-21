<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The Root Directory
    |--------------------------------------------------------------------------
    |
    | The root directory that will be used to push the modules to
    |
    */

    'root_dir' => base_path() . '/core',

    /*
    |--------------------------------------------------------------------------
    | The Plugins Directory
    |--------------------------------------------------------------------------
    |
    | The plugins directory that will be used to push the modules to
    |
    */

    'plugins_dir' => base_path() . '/plugins',

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
        'ApiTestCase.stub'           => 'Tests/ApiTestCase.php',
        'WebTestCase.stub'           => 'Tests/WebTestCase.php',
        'Uuid.stub'                  => 'Traits/Model/Uuid.php',
        'SendResponse.stub'          => 'Traits/Response/SendResponse.php',
        'File.stub'                  => 'Traits/ServiceProvider/File.php',
        'Module.stub'                => 'Traits/ServiceProvider/Module.php',
        'Path.stub'                  => 'Traits/Views/Path.php',
        'Variable.stub'              => 'Traits/Views/Variable.php',
        'views'                      => 'views/*',
        'unit_template'              => 'unit_template/*',
        'ModuleServiceProvider.stub' => 'ModuleServiceProvider.php'
    ],
    'main_views' => [
        'layouts'  => ['master.blade.php'],
        'layouts/partials' => ['_navbar.blade.php', '_sidebar.blade.php']
    ],

    /*
    |--------------------------------------------------------------------------
    | The Base (Plugins)
    |--------------------------------------------------------------------------
    |
    | The stubs and files for the Base Module (Plugins)
    |
    */

    'plugins_base' => [
        'main.php'                   => 'config/main.php',
        'api.php'                    => 'routes/api.php',
        'web.php'                    => 'routes/web.php',
        'ModuleServiceProvider.stub' => 'ModuleServiceProvider.php'
    ],

    /*
    |--------------------------------------------------------------------------
    | The Module
    |--------------------------------------------------------------------------
    |
    | The stubs and files for the new Modules & Units
    |
    */

    'module' => [
        'main_files' => [
            'main.php'                   => 'config/main.php',
            'api.stub'                   => 'routes/api.php',
            'web.stub'                   => 'routes/web.php',
            'ModuleServiceProvider.stub' => 'ModuleServiceProvider.php'
        ],
        'unit_main_folders' => [
            'UnitApiController.stub'     => 'Controllers/API/V1/',
            'UnitWebController.stub'     => 'Controllers/Web/',
            'Unit.stub'                  => 'Models/',
            'Unit.json'                  => 'data/'
        ],
        'unit_folders' => [
            'date_create_units_table.stub'                 => 'Database/Migrations/',
            'UnitRequest.stub'                             => 'Requests/',
            'UnitResource.stub'                            => 'Resources/',
            'UnitTest.stub'                                => 'Tests/Feature/',
            'UnitFactory.stub'                             => 'Database/Factories/',
            // base_path() . '/../Base/unit_template'         => 'views/'
        ],
        'advance' => [
            'Unit.json' => 'data/'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | The Validation
    |--------------------------------------------------------------------------
    |
    | The validation attributes that will be used in the response
    |
    */

    'validation' => [
        'field'   => 'field',
        'message' => 'message',
        'code'    => 'code',
    ],
];
