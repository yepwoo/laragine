<?php

namespace Yepwoo\Laragine\Processors;

use Illuminate\Support\Str;

class RequestProcessor extends Processor
{
    /**
     * start processing
     *
     * @return string[]
     */
    public function process(): array
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

            if($schema_types[$type]) {
                $type = $schema_types[$type]['resource'] !== "" ? $schema_types[$type]['resource'] . '|' : "";
                $this->processors['request_str'] .= <<<STR
                                                '$column' => '$type
                            STR;
            } else {
                $this->processors['request_str'] .= <<<STR
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
                        $this->processors['request_str'] .= $schema_modifiers[$modifier]['resource'] . ':' . $this->unit_collection['plural_lower_case'] . '|';
                    } else {
                        $this->processors['request_str'] .= $modifier . '|';
                    }
                }
            }

            if($nullable) {
                $this->processors['request_str'] .= 'nullable' . "'";
            } else {
                $this->processors['request_str'] .= 'required' . "'";
            }
            $this->processors['request_str']  .= array_key_last($attributes) == $column ? ',' : ",\n";
        }

        return $this->processors;
    }

}
