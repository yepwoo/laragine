<?php

namespace Yepwoo\Laragine\Controllers\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Model;
use Yepwoo\Laragine\Traits\Response\SendResponse;

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
     * @param Model $model
     * @param string $resource
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
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->sendResponse(new $this->resource($this->getModel($id)));
    }

    /**
     * Update a resource in storage.
     *
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $model = $this->getModel($id);
        $model->update($this->request->all());
        return $this->sendResponse(new $this->resource($model), 'successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $model = $this->getModel($id);
        $model->delete();
        return $this->sendResponse([], 'successfully deleted.');
    }

    /**
     * get the model by specific column
     * 
     * @codeCoverageIgnore
     * @param  string $id
     * @param  string $column
     * @return Model
     */
    protected function getModel($id, $column = 'uuid')
    {
        return $this->model->where($column, $id)->first();
    }
}
