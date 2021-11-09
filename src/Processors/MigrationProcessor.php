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

    public function process() {
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

    public function typeCase($type, $column)
    {
        $schema_types = $this->schema['types'];
        $type = explode(":", strtolower($type))[0];

        if(($this->isSchemaTypeFound($type))) {
            $has_value = $schema_types[$type]['has_value'];

           if($has_value) {
                // if has value
           } else {
               $this->type_str .= $schema_types[$type]['migration']. '('."'$column'".')';
           }
        }
    }

    public function modCase() {

    }
}
