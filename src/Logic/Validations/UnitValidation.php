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
        $this->schema  = json_decode(json_encode(FileManipulator::getSchema()), true);
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
            // @codeCoverageIgnoreStart
            throw new \Exception("Call to undefined method ".__CLASS__."::$method()");
            // @codeCoverageIgnoreEnd
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
            $this->command->error(__('laragine::unit.module_missing'));
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
                $this->command->error(__('laragine::unit.init_executed'));
            }
        } else {
            if (!FileManipulator::exists("{$module_dir}/data/{$unit_collection['studly']}.json")) {
                $this->allow_proceed = false;
                $this->command->error(__('laragine::unit.init_not_executed'));
            }

            /**
             * @todo check migrations, factories, requests, resources and tests as it's currently check for requests
             */
            if (FileManipulator::exists("{$module_dir}/Requests/{$unit_collection['studly']}Request.php")) {
                if ($this->command->confirm(__('laragine::unit.exists'), true)) {
                    $this->allow_proceed = true;
                } else {
                    $this->allow_proceed = false;
                    $this->command->warn(__('laragine::unit.not_overwritten'));
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
        (7) has value definition case: check if write value for this definition
        (8) doesn't have value case: check if write value for this definition

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
                $this->command->error(__('laragine::unit.attributes_prop_required'));
            } else {
                foreach ($this->attributes as $column_name => $cases) {
                    // ========= (2) ========
                    if(!isset($cases['type'])) {
                        $this->allow_proceed = false;
                        $params = ['column_name' => $column_name, 'unit_studly' => $unit_collection['studly']];
                        $this->command->error(__('laragine::unit.type_prop_required', $params));
                    } else {
                        $this->typeCase($cases['type'], $column_name, $unit_collection);

                        if(isset($cases['definition'])) {
                            $this->definitionCase($cases['definition']);
                        }
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
        $type = explode(":", $type_value)[0];
        $schema_types = $this->schema['types'];

        // ========= (3) ========
        if(!$this->isSchemaFound('types', $type)) {
            $this->allow_proceed = false;
            $this->command->error(__('laragine::unit.type_prop_not_valid', ['type' => $type]));
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
        $type = explode(":", $type_value)[0];
        $has_value = $schema_types[$type]['has_value'];
        $values    = explode(":", $type_value);

        if($has_value) {
            // ======= (4) =======
            if(!$this->hasValue($values)) {
                $this->allow_proceed = false;
                $this->command->error(__('laragine::unit.type_prop_has_value', ['type' => $type]));
            }
        } else {
            // ====== (5) ====
            if($this->hasValue($values)) {
                $this->allow_proceed = false;
                $this->command->error(__('laragine::unit.type_prop_has_no_value', ['type' => $type]));
            }
        }
    }

    /**
     * Validation definition case
     *
     * @param $definition_value
     */
    protected function definitionCase($definition_value) {
        $definitions = explode('|', $definition_value);
        foreach ($definitions as $single_definition) {
            $definition         = explode(":", $single_definition)[0];
            $schema_definitions = $this->schema['definitions'];

            // ===== (6) =====
            if(!$this->isSchemaFound('definitions', $definition)) {
                $this->allow_proceed = false;
                $this->command->error(__('laragine::unit.definition_prop_not_valid', ['definition' => $definition]));
            } else {
                $this->handleDefinitionValue($schema_definitions, $single_definition);
            }
        }
    }

    /**
     * Validation on definition values (single - multiple)
     *
     * @param $schema_definitions
     * @param $definition_value
     */
    protected function handleDefinitionValue($schema_definitions, $definition_value) {
        $definition = explode(":", $definition_value)[0];
        $has_value  = $schema_definitions[$definition]['has_value'];
        $values     = explode(":", $definition_value);

        if($has_value) {
            // ======= (7) =======
            if(!$this->hasValue($values)) {
                $this->allow_proceed = false;
                $this->command->error(__('laragine::unit.definition_prop_has_value', ['definition' => $definition]));
            }
        } else {
            // ====== (8) ====
            if($this->hasValue($values)) {
                $this->allow_proceed = false;
                $this->command->error(__('laragine::unit.definition_prop_has_no_value', ['definition' => $definition]));
            }
        }
    }

    /**
     * Check if type has value or not
     *
     * @param $arr
     * @return bool
     */
    protected function hasValue($arr): bool
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
