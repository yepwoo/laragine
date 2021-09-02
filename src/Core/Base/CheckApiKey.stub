<?php

namespace Core\Base\Middleware;

use Closure;
use Core\Base\Traits\Response\SendResponse;

class CheckApiKey
{
    use SendResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->headers->has('api-key')) {
            $errors = [['message' => 'api key should be provided in the header', 'code' => 1101]];
            return $this->sendResponse($errors, 'api key not provided.', false, 401);
        } elseif ($request->header('api-key') != config('core_base.api_key')) {
            $errors = [['message' => 'api key is not valid', 'code' => 1102]];
            return $this->sendResponse($errors, 'invalid api key.', false, 401);
        }

        return $next($request);
    }
}
