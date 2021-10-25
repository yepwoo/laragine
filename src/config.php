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
            'ModuleServiceProvider.stub' => 'ModuleServiceProvider.php'
        ],
        'unit_main_folders' => [
            'UnitApiController.stub'     => 'Controllers/API/V1/',
            'UnitWebController.stub'     => 'Controllers/Web/',
            'Unit.stub'                  => 'Models/',
            'Unit.json'                  => 'data/'
        ],
        'unit_folders' => [
            'create_units_table.stub'                      => 'Database/Migrations/',
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
    | Configuration
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    'config_name' => [ // @todo will name the name of the array
        'types' => [
            'integer' => [
              'have_value' => false,
              'request'    => '',
              'factorial'  => '',
              'migration'  => '',
              'resource'   => '',
            ],
            'bigIncrements' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'bigInteger' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'binary' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'boolean' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'dateTimeTz' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'dateTime' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'date' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'geometryCollection' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'geometry' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'ipAddress' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'json' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'jsonb' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'lineString' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'longText' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'macAddress' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'mediumIncrements' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'mediumInteger' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'mediumText' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'morphs' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'timestamps' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'timestampsTz' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'text' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'string' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'foreignId' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'increments' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],

            // with value
            'enum' => [
                'have_value' => true,
                'is_array'   => true,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'float' => [
                'have_value' => true,
                'is_array'   => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'double' => [
                'have_value' => true,
                'is_array'   => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'char' => [
                'have_value' => true,
                'is_array'   => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'timestamp' => [
                'have_value' => true,
                'is_array'   => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'timestampTz' => [
                'have_value' => true,
                'is_array'   => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'time' => [
                'have_value' => true,
                'is_array'   => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'timeTz' => [
                'have_value' => true,
                'is_array'   => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
        ],
        'modifiers' => [
            'autoIncrement' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'first' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'unsigned' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'useCurrent' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'useCurrentOnUpdate' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'always' => [
                'have_value' => false,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],

            // with value
            'after' => [
                'have_value' => true,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'charset' => [
                'have_value' => true,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'collation' => [
                'have_value' => true,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'comment' => [
                'have_value' => true,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'default' => [
                'have_value' => true,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'from' => [
                'have_value' => true,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'storedAs' => [
                'have_value' => true,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'virtualAs' => [
                'have_value' => true,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
            'generatedAs' => [
                'have_value' => true,
                'request'    => '',
                'factorial'  => '',
                'migration'  => '',
                'resource'   => '',
            ],
        ]
    ],
    'data_types' => [
        'type_with_given_values' => [ 'enum', 'float', 'double', 'char', 'timestamp', 'timestampTz', 'time', 'timeTz'],
        'type_have_array_value' => ['enum'],
        'type_without_given_values' => [
            'bigIncrements', 'bigInteger', 'integer', 'binary', 'boolean', 'dateTimeTz', 'dateTime', 'date', 'geometryCollection',
            'geometry', 'increments', 'integer', 'ipAddress', 'json', 'jsonb', 'lineString', 'longText', 'macAddress', 'mediumIncrements',
            'mediumInteger', 'mediumText', 'morphs', 'timestamps', 'timestampsTz', 'text', 'string', 'foreignId' // still have more inputs
        ],

        /*

            'with_value' => [
                'integer' => [
                    'reg' => 'int',
                    'fact'=> ''
                ],

                'bigIncrement' => [

                ]
            ]

            'with_value' => [
                'enum' => 'array'
                'float' => 'comma_seperated',
                'double' => 'float_comma_seperate',
                'char',
                'timestamp',
                'timestampTz' => [ // @todo like this structure
                    has_value => true,
                    type => array,
                    request_value => integer
                    factory_value =>
                ]
                'time',
                'timeTz'
            ]

            'without_value' => [

            ]


            request => [
                'int' => 'integer',
                'flt' => 'dobule'
            ]

            == types ===
            - multiple -> put type multiple, put value #validation

            - single
            - contain dot: return error
            - be sure writing all type & modifiers from laravel
            - check if write type & modifier include in config or not
            - must write one type, by pipe '|'
            - mutiple -> check put value, check valid multiple type
         */

    ],

    /**
     * modifier case: with value, without value
     */
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

    'db_types_in_request' => ['string', 'integer', 'nullable', 'unique'],

    'factory_array' => [
        'text' => [
            'string',
            'lineString',
            'text',
            'longText',
            'mediumText',
            'tinyText'
        ],
        'integer' => [
            'integer',
            'mediumInteger',
            'unsignedInteger',
            'tinyInteger',
            'float',
            'double',
            'smallInteger',
            'bigInteger'
        ],

        'boolean' => 'boolean',

        'special_cases' => [
            'email' => 'safeEmail',
            'phone' => 'phoneNumber',
            'url'   => 'url'
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
