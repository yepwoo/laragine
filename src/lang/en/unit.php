<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Unit
    |--------------------------------------------------------------------------
    |
    | The messages that will be outputted in the console for the unit stuff
    |
    */

    'module_required'              => 'Module is required please add --module=YourModuleName',
    'module_missing'               => 'Please create the module first',
    'init_executed'                => 'You already ran this command before',
    'init_not_executed'            => 'Please type --init at the end of the command',
    'exists'                       => 'the unit already exists, do you want to override it?',
    'not_overwritten'              => 'Existing unit was not overwritten',
    'attributes_prop_required'     => 'Please be sure to type attributes property in the JSON file',
    'type_prop_required'           => 'Please specify the type of :column_name property in :unit_studly.json file',
    'type_prop_not_valid'          => 'Sorry we didn\'t recognize :type type in our schema',
    'type_prop_has_value'          => 'The :type type should have values, please specify the value',
    'type_prop_has_no_value'       => 'The :type type shouldn\'t have values, please specify the value',
    'definition_prop_not_valid'    => 'Sorry we didn\'t recognize :definition definition in our schema',
    'definition_prop_has_value'    => 'The :definition definition should have values, please specify the value',
    'definition_prop_has_no_value' => 'The :definition definition shouldn\'t have values, please remove the value',
    'success_init_executed'        => 'Unit created successfully!',
    'success_init_not_executed'    => 'Other stuff in the unit created successfully'

];
