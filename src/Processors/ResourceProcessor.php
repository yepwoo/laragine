<?php

namespace Yepwoo\Laragine\Processors;

class ResourceProcessor extends Processor
{
    /**
     * start processing
     *
     * @return string[]
     */
    public function process()
    {
        foreach ($this->json['attributes'] as $key => $value) {
            echo json_encode($key);exit;
//            $this->data['replace']['content'][2] .= <<<CONTENT
//                                                        '$key' => \$this->$key
//                                                    CONTENT;
//            $this->data['replace']['content'][2] .= array_key_last($this->unit['attributes']) == $key ? ',' : ",\n";
        }

        return $this->json;
    }
}
