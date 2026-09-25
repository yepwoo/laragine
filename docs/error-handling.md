## Error Handling

We recommend to use Laragine to handle the errors in your application, as the package contains one clear structure to send the response back to the client side (mobile app, third party system, web app ...etc) so in order for you to do so, you have to do the following:

In `bootstrap/app.php`, pass the exception configurator to `Yepwoo\Laragine\Exceptions\Handler::handle()`:

```php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Yepwoo\Laragine\Exceptions\Handler as LaragineHandler;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        LaragineHandler::handle($exceptions);
    })->create();
```

That registers Laragine's responses for authentication (`401`), authorization (`403`), validation (`422`) and any other uncaught `Throwable` (`500`).

If your application still routes exceptions through a handler class of its own, the underlying trait is available directly. Use `Yepwoo\Laragine\Traits\Exceptions\Handler` and call `handleExceptions()` from the class' `register()` method:

```php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Yepwoo\Laragine\Traits\Exceptions\Handler as LaragineHandler;

class Handler extends ExceptionHandler
{
    use LaragineHandler;

    public function register()
    {
        $this->handleExceptions();
    }
}
```

Now, we need to use this helper function `client_validation_response` (it accepts 2 arguments, the first is the rules array and the second (optional) is the start error code) in the validation file `lang/en/validation.php`. Publish it first if it is not there yet:

```bash
php artisan lang:publish
```

Then assign the array to a variable and return the helper function, here is the full code snippet:

```php
$array = [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',

    ...

];

return client_validation_response($array);
```
