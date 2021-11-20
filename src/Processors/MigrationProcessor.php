<?php

namespace Yepwoo\Laragine\Processors;

class MigrationProcessor extends Processor
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

    public function __construct(...$args)
    {
        parent::__construct(...$args);
    }

    public function process(): string
    {
        $attributes = $this->json['attributes'];
        foreach ($attributes as $column => $cases) {
            $this->type_str       = '';
            $this->definition_str = '';

            $this->processor .= <<<STR
                                    \$table->
                        STR;

            $this->typeCase($cases['type'], $column);

            if(isset($cases['definition'])) {
                $this->definitionCase($cases['definition']);
            }

            $this->processor  .= $this->type_str . ($this->definition_str !== '' ? '->' . $this->definition_str : '');
            $this->processor  .= array_key_last($this->json['attributes']) == $column ? ';' : ";\n";
        }
        return $this->processor;
    }

    /**
     * Type case
     *
     * @param $type_str
     * @param $column
     */
    public function typeCase($type_str, $column)
    {
        $schema_types = $this->schema['types'];
        $type = explode(":", strtolower($type_str))[0];

        if(($this->isSchemaFound('types', $type))) {
            $has_value = $schema_types[$type]['has_value'];

           if($has_value) {
               $values = explode(",", explode(":", strtolower($type_str))[1]);
               $type_value = '';
               foreach($values as $value) {
                   if (is_numeric($value)) {
                       $type_value .= $values[count($values) - 1] == $value ? (int)$value : (int)$value. ",";
                   } else {
                       $type_value .= $values[count($values) - 1] == $value ? "'$value'" : "'$value'". ",";
                   }
               }
               $value_type = $schema_types[$type]['value_type'] ?? null;
               $argument   = $this->isOneValueType($value_type) ? "$type_value" : "[$type_value]";

               $this->type_str .= $schema_types[$type]['migration'] . '('."'$column', ". $argument .')';
               return;
           }
               $this->type_str .= $schema_types[$type]['migration']. '('."'$column'".')';
        }
    }

    public function definitionCase($definition_str) {
        $schema_definitions = $this->schema['definitions'];
        $definitions        = explode("|", strtolower($definition_str));

        foreach ($definitions as $definition) {
            $single_definition = explode(":", strtolower($definition))[0];

            if($this->isSchemaFound('definitions', $single_definition)) {
                $has_value = $schema_definitions[$single_definition]['has_value'];

                if($has_value) {
                    $values = explode(",", explode(":", strtolower($definition))[1]);
                    $definition_value = '';

                    foreach($values as $value) {
                        if (is_numeric($value)) {
                            $definition_value .= $values[count($values) - 1] == $value ? (int)$value : (int)$value. ",";
                        } else {
                            $definition_value .= $values[count($values) - 1] == $value ? "'$value'" : "'$value'". ",";
                        }
                    }
                    $value_type = $schema_definitions[$single_definition]['value_type'] ?? null;
                    $argument   = $this->isOneValueType($value_type) ? "($definition_value)" : "([$definition_value])";

                    $this->definition_str .= $schema_definitions[$single_definition]['migration'] . $argument .'->';
                } else {
                    $this->definition_str .= $schema_definitions[$single_definition]['migration'] . '()' . '->' ;
                }
            }
        }
        $this->definition_str = substr($this->definition_str, 0, -2);
    }
}
