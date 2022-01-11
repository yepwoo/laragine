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
            $type = explode(':', $value['type'])[0];
            if (!$this->isRelationType($type)) {
                $this->setInitStr($key);
                $this->processor .= ",\n";
            }
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
