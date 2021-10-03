# Laragine
We developed Laragine to make the software development using Laravel faster and cleaner, so you can get things done faster, not only that, Laragine is not about quantity only, it's all about quantity and quality.

### Features
It's very important to know why to use Laragine, here is why:

* A module based, meaning that you can separate all related stuff together

* You can create CRUD operations including the `requests`, `resources`, `models`, `migrations`, `factories`, `views` ...etc by doing simple stuff (don't worry, it's explained in the documentation)

* Unit Tests are also created!

* One clear response for the client side (for example: API response)

* Many helper functions/traits/classes that will come in handy while you develop! (error handling, adding more info to the logs, security helpers ...etc)

### Getting Started
To get started please check the [documentation](https://yepwoo.com/laragine/docs/index.html)

### Contributions
Please note that Laragine source code isn't in its best version yet, currently our first priority is to rewrite the whole source code again so we can scale fast.

Any contribution including pull requests, issues, suggestions or any thing that will make Laragine better is welcomed and much appreciated.

### Apart from reading the documentation you can also check the below sections to get an idea

### Introduction

To get started, require the package:

```bash
composer require yepwoo/laragine
```

Note that: Laragine currently is working on **Laravel 8** (`^8.0`).

### Install the package

After including Laragine, you have to install it by running the following command:

```bash
php artisan laragine:install
```

### Notes

* Laragine directory will be in the root directory under `Core` directory

* The system response (including errors response if you applied what's in `Error Handling` section) to any request will be as in below examples (`status_code` is the http status code):

**Success Response:**

```json
{
  "is_success": true,
  "status_code": 200,
  "message": "Success.",
  "data": ...,
  "links": ...,
  "meta": ...
}
```

`links` and `meta` will be provided if the data is **paginated**.


**Error Response:**

```json
{
  "is_success": false,
  "status_code": 401,
  "message": "Error.",
  "errors": ...
}
```

### Commands

Needed commands to start using the package:

`php artisan laragine:install`

To install the package.

After installing the package you will find a directory called `unit_template` inside `core/Base`, that's the directory that has the default views that will be included in every unit you generate (after running this command `php artisan laragine:unit {UnitName} {--module=ModuleName}` keep reading to learn more about this command).

Please take a look at the blade files inside `core/Base/views` and `core/Base/unit_template` you will notice that `$global` variable is shared across all the views.

`php artisan laragine:module {ModuleName}`

To create new module, here is an example:

```bash
php artisan laragine:module Todo
```

`php artisan laragine:unit {UnitName} {--module=ModuleName} {--init}`

To initialize the unit with basic stuff (model, API controller and Web Controller) and after running the command you can configure the unit, here is an example:

```bash
php artisan laragine:unit Task --module=Todo --init
```

then navigate to `core/Todo/data/Task.json` and update it like in the following:

```json
{
  "attributes": {
    "name": {
      "type": "string"
    },
    "description": {
      "type": "text",
      "mod": "nullable"
    },
    "priority": {
      "type": "enum:low,medium,high",
      "mod": "nullable|default:medium"
    },
    "is_done": {
      "type": "boolean",
      "mod": "default:false"
    }
  },
  "relations": {
      this feature will be released soon...
  }
}
```

Please note the following:

`attributes`: contains the unit attributes (you can think of attributes as the columns of the table in the database).

`type`: the type of the attribute, please check all available types [here](https://laravel.com/docs/8.x/migrations#available-column-types)

`mod`: it holds the column modifiers in the database, please check all available modifiers from [here](https://laravel.com/docs/8.x/migrations#column-modifiers)

You may have noticed that the values in `type` and `mod` are designed the same way as we do in the validation rules.

`php artisan laragine:unit {UnitName} {--module=ModuleName}`

To create all the related stuff (migration, request, resource, factory, unit test ...etc) based on the previous command:

```bash
php artisan laragine:unit Task --module=Todo
```

### Error Handling

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

Now, we need to use this helper function `client_validation_response` (it accepts 2 arguments, the first is the rules array and the second (optional) is the start error code) in the validation file `resources\lang\en\validation.php` by assigning the array to a variable and then return the helper function, here is the full code snippet:

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

### Middlewares

Useful middlewares to help you protect the system and for better security:

`CheckApiKey`

to check if the client side includes a valid `api-key` header in any API request.

to use it, first add `API_KEY=your_api_key_here` in `.env` file, second in the **Kernel** (`app\Http\Kernel.php`) add it in `$routeMiddleware` as below:

```php
protected $routeMiddleware = [
    
    ...

    'api-key' => \Core\Base\Middleware\CheckApiKey::class
];
```

then add it in `$middlewareGroups` in the api middleware that you use, so it might be `api` or `auth:api` so it will be like so:

```php
protected $middlewareGroups = [

    ...

    'api' => [
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Core\Base\Middleware\CheckApiKey::class
    ],
];
```

or like so:

```php
protected $middlewareGroups = [

    ...

    'auth:api' => [
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Core\Base\Middleware\CheckApiKey::class
    ],
];
```

### Logs

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

### Config

You will notice in any module you generate, a `config` directory, so basically you can add configuration for the module, and you can access it in this form: `config('core_modulename.some_key')` for example: `config('core_base.api_key')`

### Testing

This section is very important and it's **`required`** to apply all the instructions here, in order for you to run the tests correctly.

We need to do 3 things in `phpunit.xml` in the root directory:

(1) change the value of `bootstrap` attribute to `vendor/yepwoo/laragine/src/autoload.php` in `phpunit` tag (it's the same as `vendor/autoload.php` but with needed stuff to run the tests correctly in the generated modules and units).

(2) add the following to `Unit` test suite:

`<directory suffix=".php">./core/*/Tests/Unit</directory>`

`<directory suffix=".php">./plugins/*/Tests/Unit</directory>`

(3) add the following to `Feature` test suite:

`<directory suffix=".php">./core/*/Tests/Feature</directory>`

`<directory suffix=".php">./plugins/*/Tests/Feature</directory>`

Here is the full code snippet:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="./vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/yepwoo/laragine/src/autoload.php"
         colors="true"
>
    <testsuites>
        <testsuite name="Unit">
            <directory suffix="Test.php">./tests/Unit</directory>
            <directory suffix=".php">./core/*/Tests/Unit</directory>
            <directory suffix=".php">./plugins/*/Tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory suffix="Test.php">./tests/Feature</directory>
            <directory suffix=".php">./core/*/Tests/Feature</directory>
            <directory suffix=".php">./plugins/*/Tests/Feature</directory>
        </testsuite>
    </testsuites>

    ...

</phpunit>
```