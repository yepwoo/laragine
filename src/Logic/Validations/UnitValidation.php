<?php

namespace Yepwoo\Laragine\Logic\Validations;

use Illuminate\Console\Command;
use Yepwoo\Laragine\Logic\FileManipulator;
use Yepwoo\Laragine\Logic\StringManipulator;

class UnitValidation
{
    /**
     * a flag to move forward or not
     *
     * @var bool
     */
    public $allow_proceed = true;

    /**
     * related command
     *
     * @var Command
     */
    protected $command;

    /**
     * Json data
     */
    protected $attributes;

    /**
     * Schema data
     */
    protected $schema;

    /**
     * init
     *
     * @param  Command $command
     * @return void
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
        $this->schema  = FileManipulator::getSchema();
    }

    /**
     * magic method __call
     *
     * @return $this
     * @throws \Exception
     */
    public function __call($method, $args)
    {
        if (!method_exists($this, $method)) {
            throw new \Exception("Call to undefined method ".__CLASS__."::$method()");
        }

        call_user_func_array([$this, $method], $args);

        return $this;
   }

    /**
     * check if the module exists or not
     *
     * @param  string $module_dir
     * @return void
     */
    protected function checkModule($module_dir)
    {
        if (!FileManipulator::exists($module_dir)) {
            $this->allow_proceed = false;
            $this->command->error('Please create the module first');
        }
    }

    /**
     * check the unit
     *
     * @param  string   $module_dir
     * @param  string[] $unit_collection
     * @param  boolean  $init
     * @return void
     */
    protected function checkUnit($module_dir, $unit_collection, $init)
    {
        if ($init) {
            if (FileManipulator::exists("{$module_dir}/data/{$unit_collection['studly']}.json")) {
                $this->allow_proceed = false;
                $this->command->error('You already ran this command before');
            }
        } else {
            if (!FileManipulator::exists("{$module_dir}/data/{$unit_collection['studly']}.json")) {
                $this->allow_proceed = false;
                $this->command->error('Please type --init at the end of the command');
            }

            /**
             * @todo check migrations, factories, requests, resources and tests as it's currently check for requests
             */
            if (FileManipulator::exists("{$module_dir}/Requests/{$unit_collection['studly']}Request.php")) {
                if ($this->command->confirm('the unit already exists, do you want to override it?', true)) {
                    $this->allow_proceed = true;
                } else {
                    $this->allow_proceed = false;
                    $this->command->warn('Existing unit was not overwritten');
                }
            }
        }
    }

    /**
     * check attributes
        (1) check if write attributes property in JSON file
     * Type case
        (2) check if specify the type of "attribute"
        (3) check if the type is exist in our schema
        (4) has value type case: check if write value for this type
        (5) doesn't have value case: check if write value for this type
     * Modifier case
        (6) check if module is exist in our schema data
        (7) has value modifier case: check if write value for this modifier
        (8) doesn't have value case: check if write value for this modifier

     *
     * @param $root_dir
     * @param $module_collection
     * @param $unit_collection
     */
    protected function checkAttributes($root_dir, $module_collection, $unit_collection) {
        $file_name = $unit_collection['studly'].'.json';
        $full_path = $root_dir . '/' .  $module_collection['studly'] . '/data/' . $file_name;
        if (FileManipulator::exists($full_path)) {
            $this->attributes   = FileManipulator::readJson($full_path)['attributes'] ?? null;

            // ========= (1) ========
            if ($this->attributes == null) {
                $this->allow_proceed = false;
                $this->command->error('Please be sure that you write attribute property in JSON file');
            } else {
                foreach ($this->attributes as $column_name => $cases) {
                    $this->typeCase($cases['type'], $column_name, $unit_collection);

                    if(isset($cases['mod'])) {
                        $this->modCase($cases['mod']);
                    }
                }
            }
        }
    }


    /**
     * Validation type case
     *
     * @param $type_value
     * @param $column
     * @param $unit_collection
     */
    protected function typeCase($type_value, $column, $unit_collection) {
        $type = explode(":", strtolower($type_value))[0];
        $schema_types = $this->schema['types'];

        // ========= (2) ========
        if(!isset($type)) {
            $this->allow_proceed = false;
            $this->command->error("Please specify the type of '$column' property in " .$unit_collection['studly']. ".json file");
        }

        // ========= (3) ========
        if(!$this->isSchemaFound('types', $type)) {
            $this->allow_proceed = false;
            $this->command->error("Sorry we didn't recognize '$type' type in our schema");
        } else { // type found in our schema
            $this->handleTypeValue($schema_types, $type_value);
        }
    }

    /**
     * Validation on type values (single - multiple)
     *
     * @param $schema_types
     * @param $type_value
     */
    protected function handleTypeValue($schema_types, $type_value) {
        $type = explode(":", strtolower($type_value))[0];
        $has_value = $schema_types[$type]['has_value'];
        $values    = explode(":", strtolower($type_value));

        if($has_value) {
            // ======= (4) =======
            if(!$this->haveValue($values)) {
                $this->allow_proceed = false;
                $this->command->error("The '$type' type should have values, please specify the value");
            }
        } else {
            // ====== (5) ====
            if($this->haveValue($values)) {
                $this->allow_proceed = false;
                $this->command->error("The '$type' type shouldn't have values, please remove the value");
            }
        }
    }

    /**
     * Validation mod case
     *
     * @param $mod_value
     */
    protected function modCase($mod_value) {
        $mod = explode(":", strtolower($mod_value))[0];
        $schema_modifiers = $this->schema['definitions'];

        // ===== (6) =====
        if(!$this->isSchemaFound('definitions', $mod)) {
            $this->allow_proceed = false;
            $this->command->error("Sorry we didn't recognize '$mod' modifier in our schema");
        } else {
            $this->handleModValue($schema_modifiers, $mod_value);
        }
    }

    /**
     * Validation on modifier values (single - multiple)
     *
     * @param $schema_definitions
     * @param $mod_value
     */
    protected function handleModValue($schema_definitions, $mod_value) {
        $mod       = explode(":", strtolower($mod_value))[0];
        $has_value = $schema_definitions[$mod]['has_value'];
        $values    = explode(":", strtolower($mod_value));

        if($has_value) {
            // ======= (7) =======
            if(!$this->haveValue($values)) {
                $this->allow_proceed = false;
                $this->command->error("The '$mod' modifier should have values, please specify the value");
            }
        } else {
            // ====== (8) ====
            if($this->haveValue($values)) {
                $this->allow_proceed = false;
                $this->command->error("The '$mod' modifier shouldn't have values, please remove the value");
            }
        }
    }

    /**
     * Check if type have value or not
     *
     * @param $arr
     * @return bool
     */
    protected function haveValue($arr): bool
    {
        return count($arr) > 1;
    }
    /**
     * Check if type is in our schema
     *
     * @param $type
     * @return bool
     */
    protected function isSchemaFound($prop, $type): bool
    {
        return isset($this->schema[$prop][$type]);
    }

}
