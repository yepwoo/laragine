## Error Handling

We recommend to use Laragine to handle the errors in your application, as the package contains one clear structure to send the response back to the client side (mobile app, third party system, web app ...etc) so in order for you to do so, you have to do the following:


in `app\Exceptions\Handler.php` use this trait `Yepwoo\Laragine\Traits\Exceptions\Handler` after that use this method `handleExceptions()` inside the `register()` method, here is the full code snippet:

```php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Yepwoo\Laragine\Traits\Exceptions\Handler as LaragineHandler;

class Handler extends ExceptionHandler
{
    use LaragineHandler;

    ...

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->handleExceptions();
    }
}
```

Now, we need to use this helper function `client_validation_response` (it accepts 2 arguments, the first is the rules array and the second (optional) is the start error code) in the validation file (`lang\en\validation.php` in Laravel `9.x`, `10.x` and `11.x` (in `10.x` and `11.x` you need to run this command first: `php artisan lang:publish`) or `resources\lang\en\validation.php` in Laravel `8.x`) by assigning the array to a variable and then return the helper function, here is the full code snippet:

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