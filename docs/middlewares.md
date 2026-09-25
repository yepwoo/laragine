## Middlewares

Useful middlewares to help you protect the system and for better security:

`CheckApiKey`

to check if the client side includes a valid `api-key` header in any API request.

To use it, first add `API_KEY=your_api_key_here` in your `.env` file.

Then register it in `bootstrap/app.php`. Give it an alias if you want to apply it route by route:

```php
use Illuminate\Foundation\Configuration\Middleware;

->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'api-key' => \Core\Base\Middleware\CheckApiKey::class,
    ]);
})
```

```php
Route::middleware('api-key')->group(function () {
    // ...
});
```

Or append it to the whole `api` group so every API request is checked:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->appendToGroup('api', [
        \Core\Base\Middleware\CheckApiKey::class,
    ]);
})
```

`$middleware->api(append: [...])` does the same thing and reads a little better if you are only touching the API group:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->api(append: [
        \Core\Base\Middleware\CheckApiKey::class,
    ]);
})
```
