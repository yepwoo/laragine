<?php

namespace Yepwoo\Laragine\Logic\Validators;

use Illuminate\Support\Facades\File;

class BaseValidator
{
    /**
     * the response
     * 
     * @var string[]
     */
    protected $callback;
    
    /**
     * the command
     * 
     * @var string
     */
    protected $command;
     
    /**
     * init
     * 
     * @return void
     */
    public function __construct() {
        $this->callback['flag'] = 'info';
        $this->callback['msg']  = 'Done!';
    }
    
    /**
     * check if file exists
     * 
     * @param  string $path
     * @return bool
     */
    public function isExists($path, $msg)
    {

       if (File::exists($path)) {
            $this->callback['flag'] = 'confirm';
            $this->callback['msg']  = $msg;
        }
    }

    /**
     * check if dir exists
     * 
     * @param  string $path
     * @return bool
     */
    public function isFolderExist($path) {
        
    }

    protected function stillValid() {
        return $this->callback['flag'] === 'info';
    }

    public static function columnDefinition() 
    {
        $rc = new \ReflectionClass('\Illuminate\Database\Schema\ColumnDefinition');
        print_r($rc->getDocComment());
    }
}