<?php

namespace Yepwoo\Laragine\Processors;

interface ProcessorInterface
{
    /**
     * run the logic
     *
     * @return string
     */
    public function process();
}
