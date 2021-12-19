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
            $this->setInitStr($key);
            $this->processor .= array_key_last($this->json['attributes']) == $key ? ',' : ",\n";
        }

        return $this->processor;
    }

    public function getProcessorStr()
    {
        return $this->processor;
    }

    public function setInitStr($key)
    {
        // @codeCoverageIgnoreStart
        $this->processor .= <<<STR
                                    '$key' => \$this->$key
                        STR;
        // @codeCoverageIgnoreEnd
    }
}
