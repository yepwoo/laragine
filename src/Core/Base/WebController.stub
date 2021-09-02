<?php

namespace Core\Base\Controllers\Web;

use Core\Base\Traits\Views\Path;
use Core\Base\Traits\Views\Variable;

class Controller extends \App\Http\Controllers\Controller
{
    use Path, Variable;

    /**
     * the view file namespace
     *
     * @var string
     */
    protected $namespace = 'core#base';

    /**
     * the directory that will contain the views files
     *
     * @var string
     */
    protected $directory;

    /**
     * the full path to the view directory
     *
     * @var string
     */
    protected $path;

    /**
     * init
     *
     * @codeCoverageIgnore
     * @return void
     */
    public function __construct()
    {
        $this->setupView();
        view()->share('global', $this->globalVariables());
    }

    /**
     * Display a listing of the resource.
     *
     * @codeCoverageIgnore
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view($this->path . __FUNCTION__);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @codeCoverageIgnore
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view($this->path . __FUNCTION__);
    }

    /**
     * Display the specified resource.
     *
     * @codeCoverageIgnore
     * @param  string  $uuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($uuid)
    {
        return view($this->path . __FUNCTION__);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @codeCoverageIgnore
     * @param  string  $uuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($uuid)
    {
        return view($this->path . __FUNCTION__);
    }
}
