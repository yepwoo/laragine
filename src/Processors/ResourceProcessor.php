<?php

namespace Yepwoo\Laragine\Processors;

class ResourceProcessor extends Processor
{
    /**
     * start processing
     */
    public function process(): string
    {
        foreach ($this->json['attributes'] as $key => $value) {
            $this->processor .= <<<STR
                                    '$key' => \$this->$key
                        STR;
            $this->processor .= array_key_last($this->json['attributes']) == $key ? ',' : ",\n";
        }

        return $this->processor;
    }
}
