<?php

namespace Yepwoo\Laragine\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Yepwoo\Laragine\Traits\Exceptions\Handler as HandlesLaragineExceptions;

/**
 * Wires Laragine's response format into Laravel's exception handling.
 *
 * Laravel 11 removed app/Exceptions/Handler.php in favour of configuring
 * exceptions in bootstrap/app.php. Pass the configurator to handle():
 *
 *     ->withExceptions(function (Exceptions $exceptions) {
 *         \Yepwoo\Laragine\Exceptions\Handler::handle($exceptions);
 *     })
 */
class Handler
{
    use HandlesLaragineExceptions;

    /**
     * Register Laragine's renderable callbacks on the exception configurator.
     *
     * @param  \Illuminate\Foundation\Configuration\Exceptions $exceptions
     * @return void
     */
    public static function handle(Exceptions $exceptions)
    {
        (new static())->registerExceptionHandlers($exceptions);
    }
}
