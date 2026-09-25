<?php

namespace Yepwoo\Laragine\Traits\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Core\Base\Traits\Response\SendResponse;

if (!class_exists(SendResponse::class, false)) {
    module_autoloader();
    module_autoloader('Plugins', base_path() . '/plugins');
}

trait Handler
{
    use SendResponse;

    /**
     * Register the exception handling callbacks on the given target.
     *
     * The target is anything exposing Laravel's renderable() callback
     * registration: the Exceptions configurator passed to withExceptions()
     * in bootstrap/app.php on Laravel 11 and later, or a custom exception
     * handler class that uses this trait.
     *
     * @param  object $target
     * @return void
     */
    public function registerExceptionHandlers($target)
    {
        $target->renderable(function (AuthenticationException $e, $request) {
            return $this->sendResponse([], $e->getMessage(), false, 401);
        });

        $target->renderable(function (AuthorizationException $e, $request) {
            return $this->sendResponse([], $e->getMessage(), false, 403);
        });

        $target->renderable(function (ValidationException $e, $request) {
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

        $target->renderable(function (Throwable $e, $request) {
            return $this->sendExceptionResponse($e, false);
        });
    }

    /**
     * Register the exception handling callbacks on the class using this trait.
     *
     * For applications that still route exceptions through a handler class of
     * their own. On Laravel 11 and later, prefer wiring
     * Yepwoo\Laragine\Exceptions\Handler::handle() into bootstrap/app.php.
     *
     * @return void
     */
    public function handleExceptions()
    {
        $this->registerExceptionHandlers($this);
    }
}
