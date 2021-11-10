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

            $this->processor .= $this->type_str . ($this->mod_str !== '' ? '->' . $this->mod_str : '');
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

               $this->type_str .= $schema_types[$type]['migration'] . '('."'$column',". "[$type_value]" .')';
           } else {
               $this->type_str .= $schema_types[$type]['migration']. '('."'$column'".')';
           }
        }
    }

    public function modCase($mod_value, $column) {
        $schema_modifiers = $this->schema['definitions'];
        $mod = explode(":", strtolower($mod_value))[0];

        if($this->isSchemaFound('definitions', $mod)) {
            $has_value = $schema_modifiers[$mod]['has_value'];
        }


    }
}
