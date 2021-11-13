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
     * modifier str
     *
     * @var string
     */
    private string $mod_str;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
    }

    public function process(): string
    {
        $attributes = $this->json['attributes'];
        foreach ($attributes as $column => $cases) {
            $this->type_str = '';
            $this->mod_str = '';

            $this->processor .= <<<STR
                                    \$table->
                        STR;

            $this->typeCase($cases['type'], $column);

            if(isset($cases['mod'])) {
                $this->modCase($cases['mod'], $column);
            }

            $this->processor  .= $this->type_str . ($this->mod_str !== '' ? '->' . $this->mod_str : '');
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
                       $type_value .= $values[count($values) - 1] == $value ? intval($value) : intval($value). ",";
                   } else {
                       $type_value .= $values[count($values) - 1] == $value ? "'$value'" : "'$value'". ",";
                   }
               }
               $value_type = $schema_types[$type]['value_type'] ?? null;
               $argument   = $this->isOneValueType($value_type) ? "($type_value)" : "([$type_value])";

               $this->type_str .= $schema_types[$type]['migration'] . '('."'$column',". $argument .')';
           } else {
               $this->type_str .= $schema_types[$type]['migration']. '('."'$column'".')';
           }
        }
    }

    public function modCase($mod_str, $column) {
        $schema_modifiers = $this->schema['definitions'];
        $modifiers        = explode("|", strtolower($mod_str));

        $count = 0;
        foreach ($modifiers as $modifier) {
            $mod = explode(":", strtolower($modifier))[0];

            if($this->isSchemaFound('definitions', $mod)) {
                $has_value = $schema_modifiers[$mod]['has_value'];

                if($has_value) {
                    $values = explode(",", explode(":", strtolower($modifier))[1]);
                    $mod_value = '';

                    foreach($values as $value) {
                        if (is_numeric($value)) {
                            $mod_value .= $values[count($values) - 1] == $value ? intval($value) : intval($value). ",";
                        } else {
                            $mod_value .= $values[count($values) - 1] == $value ? "'$value'" : "'$value'". ",";
                        }
                    }
                    $value_type = $schema_modifiers[$mod]['value_type'] ?? null;
                    $argument   = $this->isOneValueType($value_type) ? "($mod_value)" : "([$mod_value])";

                    $this->mod_str .= $schema_modifiers[$mod]['migration'] . $argument . ($count < (count($modifiers) - 1) ? '->' : '');
                } else {
                    echo "count: ". $count;
                    echo "\n";
                    $this->mod_str .= $schema_modifiers[$mod]['migration'] . '()' . ($count < (count($modifiers) - 1) ? '->' : '');
                }
                $count++;
            }
        }
    }
}
