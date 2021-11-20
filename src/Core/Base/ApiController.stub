<?php

namespace Core\Base\Controllers\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Model;
use Core\Base\Traits\Response\SendResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use SendResponse;

    /**
     * the request
     *
     * @var FormRequest
     */
    protected $request;

    /**
     * the eloquent model
     *
     * @var Model
     */
    protected $model;

    /**
     * the eloquent API resource
     *
     * @var string
     */
    protected $resource;

    /**
     * Init.
     *
     * @codeCoverageIgnore
     * @param FormRequest $request
     * @param Model       $model
     * @param string      $resource
     * @return void
     */
    public function __construct(FormRequest $request, Model $model, $resource)
    {
        $this->request  = $request;
        $this->model    = $model;
        $this->resource = $resource;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->sendResponse($this->resource::collection($this->model->all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        return $this->sendResponse(
            new $this->resource($this->model->create($this->request->all())),
            'successfully created.',
            true,
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->sendResponse(new $this->resource($this->model->find($id)));
    }

    /**
     * Update a resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $model = $this->model->find($id);
        $model->update($this->request->all());
        return $this->sendResponse(new $this->resource($model), 'successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $model = $this->model->find($id);
        $model->delete();
        return $this->sendResponse([], 'successfully deleted.');
    }
}
