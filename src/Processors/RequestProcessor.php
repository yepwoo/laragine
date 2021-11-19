<?php

namespace Yepwoo\Laragine\Processors;

class RequestProcessor extends Processor
{
    /**
     * start processing
     */
    public function process(): string
    {
        $attributes = $this->json['attributes'];
        $nullable   = false;

        foreach ($attributes as $column => $cases) {

            if (strpos($cases['type'], ':') !== false) {
                $cases['type'] = explode(':', $cases['type'])[0];
            }

            /**
             * === Type case
             * will extract it to different functions to make the code more readable
             */
            $type = strtolower($cases['type']);
            $schema_types = $this->schema['types'];
            $type = $schema_types[$type]['request'] !== "" ? $schema_types[$type]['request'] . '|' : "";
            $this->processor .= <<<STR
                                            '$column' => '$type
                        STR;

            /**
             * === definition case
             */
            if(isset($cases['definition'])) {
                $definitions        = explode("|", strtolower($cases['definition']));
                $schema_definitions = $this->schema['definitions'];

                foreach ($definitions as $definition) {
                    $definition = explode(":", strtolower($definition))[0];

                    if ($definition == 'nullable') {
                        $nullable = true;
                    }

                    if($schema_definitions[$definition]['request'] == 'unique') {
                        $this->processor .= $schema_definitions[$definition]['request'] . ':' . $this->unit_collection['plural_lower_case'];
                    } else {
                        $this->processor .= $definition;
                    }

                    /**
                     * need some updates here (it's not working properly here)
                     */
                    $this->processor .= array_key_last($definitions) == $definition ? '' : '|';
                }
            }

            if($nullable) {
                $this->processor .= "'";
            } else {
                $this->processor .= 'required' . "'";
            }

            $nullable = false;
            $this->processor  .= array_key_last($attributes) == $column ? ',' : ",\n";
        }

        return $this->processor;
    }

}
