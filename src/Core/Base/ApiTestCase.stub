<?php

namespace Core\Base\Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
// use Tymon\JWTAuth\Facades\JWTAuth;

class ApiTestCase extends TestCase
{
    use RefreshDatabase;

    /**
     * the base url
     *
     * @var string
     */
    protected $base_url;

    /**
     * the current model
     *
     * @var array
     */
    protected $model;

    /**
     * the data that will be sent in the request (create/update)
     *
     * @var array
     */
    protected $data;

    /**
     * the json response
     *
     * @var array
     */
    protected $json;

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

    /**
     * create new entry
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getNewEntry()
    {
        return $this->model::factory()->create();
    }

    /**
     * get the id
     *
     * @return int
     */
    protected function getId()
    {
        return $this->getNewEntry()->id;
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function testItShouldGetListingOfTheResource()
    {
        $this->getNewEntry();
        $current_json              = $this->json;
        $current_json['data']      = [];
        $current_json['data']['*'] = $this->json['data'];

        $this->json('GET', $this->base_url, [], $this->getHeaders())
             ->assertStatus(200)
             ->assertJsonStructure($current_json);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function testItShouldStoreNewlyCreatedResource()
    {
        $this->json('POST', $this->base_url, $this->data, $this->getHeaders())
             ->assertStatus(201)
             ->assertJsonStructure($this->json);
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testItShouldGetSpecifiedResource()
    {
        $this->json('GET', $this->base_url . $this->getId(), [], $this->getHeaders())
             ->assertStatus(200)
             ->assertJsonStructure($this->json);
    }

    /**
     * update a resource in storage.
     *
     * @return void
     */
    public function testItShouldUpdateSpecifiedResource()
    {
        $this->json('PUT', $this->base_url . $this->getId(), $this->data, $this->getHeaders())
             ->assertStatus(200)
             ->assertJsonStructure($this->json);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return void
     */
    public function testItShouldRemoveSpecifiedResource()
    {
        $this->json['data'] = [];
        $this->json('DELETE', $this->base_url . $this->getId(), [], $this->getHeaders())
             ->assertStatus(200)
             ->assertJsonStructure($this->json);
    }
}
