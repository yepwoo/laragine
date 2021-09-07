<?php

namespace Yepwoo\Laragine\Traits\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Core\Base\Traits\Response\SendResponse;

trait Handler
{
    use SendResponse;

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function handle_exceptions()
    {
        $this->renderable(function (AuthenticationException $e, $request) {
            return $this->sendResponse([], $e->getMessage(), false, 401);
        });

        $this->renderable(function (ValidationException $e, $request) {
            $errors         = [];
            $code_attribute = config('laragine.validation.code');
            
            foreach ($e->errors() as $field => $error) {
                $errors[] = [
                    config('laragine.validation.field')   => $field,
                    config('laragine.validation.message') => $error[0]['message'],
                    $code_attribute                       => (int)$error[0][$code_attribute],
                ];
            }
    
            return $this->sendResponse($errors, $e->getMessage(), false, 422);
        });

        $this->renderable(function (Throwable $e, $request) {
            return $this->sendExceptionResponse($e, false);
        });
    }
}
