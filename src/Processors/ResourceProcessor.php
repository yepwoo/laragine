<?php

namespace Yepwoo\Laragine\Processors;

class ResourceProcessor extends Processor
{
    /**
     * start processing
     */
    public function process(): array
    {
        foreach ($this->json['attributes'] as $key => $value) {
            $this->processors['resource_str'] .= <<<STR
                                    '$key' => \$this->$key
                        STR;
            $this->processors['resource_str']  .= array_key_last($this->json['attributes']) == $key ? ',' : ",\n";
        }

        return $this->processors;
    }
}
