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
             * === Modifier case
             */
            if(isset($cases['mod'])) {
                $modifiers        = explode("|", strtolower($cases['mod']));
                $schema_modifiers = $this->schema['definitions'];

                foreach ($modifiers as $modifier) {
                    $modifier = explode(":", strtolower($modifier))[0];
                    if($schema_modifiers[$modifier]['request'] == 'unique') {
                        $nullable = false;
                        $this->processor .= $schema_modifiers[$modifier]['request'] . ':' . $this->unit_collection['plural_lower_case'] . '|';
                    } else {
                        $nullable = true;
                        $this->processor .= $modifier . '|';
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
