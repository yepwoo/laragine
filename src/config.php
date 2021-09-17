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
        '.gitignore'                 => 'views/.gitignore',
        'ModuleServiceProvider.stub' => 'ModuleServiceProvider.php'
    ],

    /*
    |--------------------------------------------------------------------------
    | The Module
    |--------------------------------------------------------------------------
    |
    | The stubs and files for the new Modules
    |
    */

    'module' => [
        'main_files' => [
            'main.php'                   => 'config/main.php',
            'api.stub'                   => 'routes/api.php',
            'web.stub'                   => 'routes/web.php',
            '.gitignore'                 => 'views/.gitignore',
            'ModuleServiceProvider.stub' => 'ModuleServiceProvider.php'
        ],
        'unit_folders' => [
            'UnitApiController.stub'     => 'Controllers/API/V1/',
            'UnitWebController.stub'     => 'Controllers/Web/',
            'UnitFactory.stub'           => 'database/factories/',
            'create_units_table.stub'    => 'database/migrations/',
            'Unit.stub'                  => 'Models/',
            'UnitRequest.stub'           => 'Requests/',
            'UnitResource.stub'          => 'Resources/',
            'UnitTest.stub'              => 'Tests/Feature/',
        ],
        'advance' => [
            'Unit.json' => 'data/'
        ]
    ],

    'data_types' => [
        'type_with_given_values' => [ 'enum', 'float', 'double', 'char'],
        'type_have_array_value' => ['enum'],
        'type_without_given_values' => [
            'bigIncrements', 'bigInteger', 'integer', 'binary', 'boolean', 'dateTimeTz', 'dateTime', 'date', 'geometryCollection',
            'geometry', 'increments', 'integer', 'ipAddress', 'json', 'jsonb', 'lineString', 'longText', 'macAddress', 'mediumIncrements',
            'mediumInteger', 'mediumText', 'morphs' // still have more inputs
        ]
    ],
    'modifiers' => [
        'have_values' => [
            'after',
            'charset',
            'collation',
            'comment',
            'default',
            'from',
            'storedAs',
            'virtualAs',
            'generatedAs'
        ],
        'not_have_values' => [
            'autoIncrement',
            'first',
            'unsigned',
            'useCurrent',
            'useCurrentOnUpdate',
            'always'
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
