<?php

namespace Yepwoo\Laragine\Logic;

class Validator
{
    /**
     * the flag, it should be one of the following values: line, info, comment, question, warn and error
     * 
     * @var string
     */
    protected $flag;

    /**
     * console message
     * 
     * @var string
     */
    protected $message;

    /**
     * output
     * 
     * @return string[]
     */
    public function output()
    {
        return [
            'flag'    => $this->flag,
            'message' => $this->message
        ];
    }

    public function method_1()
    {
        // code ...

        $this->flag    = 'error';
        $this->message = 'some error';
    }
}
