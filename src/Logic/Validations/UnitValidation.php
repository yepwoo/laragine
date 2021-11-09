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
     * (1) check if write attributes property in JSON file
     * (2) check if specify the type of "attribute"
     * (3) check if the type is exist in our schema
     * (4) multiple type case: check if write value for this type
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
                }
            }
        }
    }


    protected function typeCase($type_str, $column, $unit_collection) {
        $type = explode(":", strtolower($type_str))[0];

        // ========= (2) ========
        if(!isset($type)) {
            $this->allow_proceed = false;
            $this->command->error("Please specify the type of '$column' property in " .$unit_collection['studly']. ".json file");
        }

        // ========= (3) ========
        if(!$this->isSchemaTypeFound($type)) {
            $this->allow_proceed = false;
            $this->command->error("Sorry we didn't recognize $type in our schema");
        } else {

        }
    }

    /**
     * Check if type is in our schema
     *
     * @param $type
     * @return bool
     */
    protected function isSchemaTypeFound($type): bool
    {
        return isset($this->schema['types'][$type]);
    }

}
