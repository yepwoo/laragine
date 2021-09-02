<?php

namespace Core\Base\Traits\Views;

trait Variable
{
    /**
     * the global variables that will be used in almost any main view file
     *
     * @codeCoverageIgnore
     * @param string[] $base
     * @return \string[][]
     */
    private function globalVariables($base = ['namespace' => 'core#base::'])
    {
        $route_name   = request()->route() ? request()->route()->getName() : '';
        $route_prefix = substr($route_name, 0, strrpos($route_name, '.'));

        return [
            'base' => [
                'namespace' => $base['namespace']
            ],
            'module' => [
                'namespace' => $this->namespace,
                'directory' => $this->directory,
                'path'      => $this->path,
                'routes' => [
                    'index'  => $route_prefix . '.index',
                    'create' => $route_prefix . '.create',
                    'show'   => $route_prefix . '.show',
                    'edit'   => $route_prefix . '.edit',
                ]
            ]
        ];
    }
}
