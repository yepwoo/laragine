<?php

namespace Yepwoo\Laragine\Processors;

use Illuminate\Support\Str;

class RequestProcessor extends Processor
{
    /**
     * start processing
     */
    public function process(): string
    {
        $attributes = $this->json['attributes'];
        $nullable         = false;

        foreach ($attributes as $column => $cases) {
            /**
             * === Type case
             * will extract it to different functions to make the code more readable
             */
            $type = strtolower($cases['type']);
            $schema_types = $this->schema['types'];

            if($this->isSchemaFound('types', $type)) {
                $type = $schema_types[$type]['resource'] !== "" ? $schema_types[$type]['resource'] . '|' : "";
                $this->processor .= <<<STR
                                                '$column' => '$type
                            STR;
            } else {
                $this->processor .= <<<STR
                                                '$column' => '
                            STR;
            }

            /**
             * === definition case
             */
            if(isset($cases['definition'])) {
                $definitions        = explode("|", strtolower($cases['definition']));
                $schema_definitions = $this->schema['definitions'];

                foreach ($definitions as $definition) {
                    $definition = explode(":", strtolower($definition))[0];
                    if($schema_definitions[$definition]['request'] == 'unique') {
                        $nullable = false;
                        $this->processor .= $schema_definitions[$definition]['request'] . ':' . $this->unit_collection['plural_lower_case'] . '|';
                    } else {
                        $nullable = true;
                        $this->processor .= $definition . '|';
                    }
                }
            }

            if($nullable) {
                $this->processor .= 'nullable' . "'";
            } else {
                $this->processor .= 'required' . "'";
            }
            $this->processor  .= array_key_last($attributes) == $column ? ',' : ",\n";
        }

        return $this->processor;
    }

}
