## Middlewares

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