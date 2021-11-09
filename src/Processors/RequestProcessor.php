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

            if(isset($schema_types[$type])) {
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
                    if($schema_modifiers[$modifier]['resource'] == 'unique') {
                        $nullable = true;
                        $this->processor .= $schema_modifiers[$modifier]['resource'] . ':' . $this->unit_collection['plural_lower_case'] . '|';
                    } else {
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