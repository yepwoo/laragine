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
            $type = $cases['type'];
            if (!$this->isRelationType($type)) {
                $schema_types = $this->schema['types'];
                $type = $schema_types[$type]['request'] !== "" ? $schema_types[$type]['request'] . '|' : "";

                // @codeCoverageIgnoreStart
                $this->processor .= <<<STR
                                            '$column' => '$type
                        STR;
                // @codeCoverageIgnoreEnd

                /**
                 * === definition case
                 */
                if(isset($cases['definition'])) {
                    $definitions        = explode("|", $cases['definition']);
                    $schema_definitions = $this->schema['definitions'];

                    foreach ($definitions as $key => $value) {
                        $value = explode(":", $value)[0];

                        if ($value == 'nullable') {
                            $nullable = true;
                        }

                        if($schema_definitions[$value]['request'] == 'unique') {
                            $this->processor .= $schema_definitions[$value]['request'] . ':' . $this->unit_collection['plural_lower_case'];
                        } else {
                            $this->processor .= $schema_definitions[$value]['request'];
                        }
                        /**
                         * need some updates here (it's not working properly here)
                         */

                        $this->processor .= (array_key_last($definitions) === $key && $nullable) ||
                        $schema_definitions[$value]['request'] === '' ? '' : '|';
                    }
                }

                if($nullable) {
                    $this->processor .= "'";
                } else {
                    $this->processor .= 'required' . "'";
                }

                $nullable = false;
                $this->processor  .= ",\n";
            }
        }

        return $this->processor;
    }

}
