<?php

namespace Core\Base\Tests;

use Tests\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
// use Tymon\JWTAuth\Facades\JWTAuth;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * get test user credentials
     *
     * @codeCoverageIgnore
     * @return string[]
     */
    protected function getUserCredentials()
    {
        return ['email' => 'test@example.com', 'password' => '123456'];
    }

    /**
     * create test user
     *
     * @codeCoverageIgnore
     * @param null|array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function createUser($data = null)
    {
        $data             = $data ?? $this->getUserCredentials();
        $data['password'] = bcrypt($data['password']);
        return User::factory()->create($data);
    }

    /**
     * get the token (to be used in the API Requests)
     *
     * @codeCoverageIgnore
     * @return string
     */
    protected function getToken()
    {
        $data = $this->getUserCredentials();
        // return JWTAuth::fromUser($this->createUser());
        return 'dummy-token';
    }

    /**
     * get the base url for API
     *
     * @codeCoverageIgnore
     * @param string $version
     * @return string
     */
    protected function getApiBaseUrl($version = 'v1')
    {
        return "api/{$version}/";
    }

    /**
     * get the needed headers for every request
     *
     * @codeCoverageIgnore
     * @param bool $is_auth
     * @return array
     */
    protected function getHeaders($is_auth = true)
    {
        $headers = [
            'Accept'  => 'application/json',
            'api-key' => config('core_base.api_key')
        ];

        if ($is_auth) {
            $headers['Authorization'] = 'Bearer ' . $this->getToken();
        }

        return $headers;
    }

    /**
     * the json response structure
     *
     * @codeCoverageIgnore
     * @param bool $is_success
     * @return array
     */
    protected function getJsonStructure($is_success = true)
    {
        $result_key = $is_success ? 'data' : 'errors';

        return [
            'is_success',
            'status_code',
            'message',
            $result_key => []
        ];
    }
}
