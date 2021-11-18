<?php

namespace Yepwoo\Laragine\Processors;

class FactoryProcessor extends Processor
{
    /**
     * type str
     *
     * @var string
     */
    private string $type_str;

    /**
     * definition str
     *
     * @var string
     */
    private string $definition_str;

    /**
     * start processing
     */
    public function process(): string
    {
        foreach ($this->json['attributes'] as $column => $cases) {
            $this->type_str       = '';
            $this->definition_str = '';

            $this->processor .= <<<STR
                                    '$column' => \$this->faker->
                        STR;

            if(isset($cases['definition'])) {
              $this->handleDefinitionCase($cases['definition']);
            }

            $this->handleTypeCase($cases['type'], $column);

            /**
             * Check if type_str is empty or not
             */

            $this->processor .= ($this->definition_str !== '' ? $this->definition_str . '->': '') . ($this->type_str !== '' ? $this->type_str : 'text()');
            $this->processor .= array_key_last($this->json['attributes']) == $column ? ',' : ",\n";
        }

        return $this->processor;
    }

    /**
     * handle definition case
     *
     * @param $single_definition
     * @return void
     */
    private function handleDefinitionCase($single_definition): void
    {
        $definitions        = explode("|", strtolower($single_definition));
        $schema_definitions = $this->schema['definitions'];

        foreach ($definitions as $definition) {
          $definition = explode(":", strtolower($definition))[0];
          if($schema_definitions[$definition] && $schema_definitions[$definition]['factory'] !== '') {
              $this->definition_str .= $schema_definitions[$definition]['factory'] . '()';
          }
        }
    }

    /**
     * handle type case
     *
     * @param $type
     * @return void
     */
    private function handleTypeCase($type, $column_name): void
    {
        $type = explode(":", strtolower($type))[0];

        $schema_types = $this->schema['types'];

        if($this->isSchemaFound('types', $type)) {
            if(!$this->isEmpty($schema_types[$type]['factory']) && !$this->isArray($schema_types[$type]['factory'])) {

                $type = $schema_types[$type]['factory'] .'()' ;
                $this->definition_str .= $type !== '' ? $type . '()': '';
            }
            else if($this->isArray($schema_types[$type]['factory'])) { // have special cases
                $special_cases = $schema_types[$type]['factory'];

                $this->handleSpecialCases($special_cases, $column_name);

                if($this->isEmpty($this->type_str)) {
                    $this->type_str .= $special_cases['default'] . '(100)';
                }
            }
        }
    }

    /**
     * Handle special cases
     *
     * @param $special_cases
     * @param $column_name
     */
    private function handleSpecialCases($special_cases, $column_name) {
        foreach ($special_cases as $case => $value) { // ex: 'email' => safeEmail
            if(strpos($column_name, $case)) {
                $this->type_str .= $value . '()';
            }
        }
    }

    /**
     * Check if var is empty
     *
     * @param $var
     * @return bool
     */
    private function isEmpty($var): bool
    {
        return $var == "";
    }

    /**
     * Check if the var is array
     *
     * @param $var
     * @return bool
     */
    private function isArray($var): bool
    {
        return is_array($var);
    }
}
