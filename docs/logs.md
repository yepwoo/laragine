## Logs

We recommend to use Laragine Logs as it adds more info to the error log, those are the details added:

`route`: Name of the route if exists

`url`: Full URL in which the error occurs

`ip`: The client IP

`time` Time of the error

`user` If the user is authenticated, his/her info will be included otherwise 'guest' will be included

`request` show the whole request, like URL, query string, body request ...etc

So to add it, go to `config\logging.php` and `use Core\Base\Logging\CustomizeFormatter` then in the channels used add `'tap' => [CustomizeFormatter::class]`. here is a full example:

```php
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Core\Base\Logging\CustomizeFormatter;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'tap' => [CustomizeFormatter::class],
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        ...

    ],

];
```