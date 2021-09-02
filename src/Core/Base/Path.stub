<?php

namespace Core\Base\Traits\Views;

use Illuminate\Support\Str;

trait Path
{
    /**
     * the exploded namespace (from the class)
     * please note that: this method should be private but I have set it to protected
     * due to testing purposes for phpunit:
     * (1) it doesn't allow setting namespace for the mocked class as we get the class directly
     *     like ClassName but we want it like so: Core\Module\Controllers\Web\AnyNameController'
     * (2) we can't mock a private method but we can mock a protected method
     *
     * @codeCoverageIgnore
     * @return string[]
     */
    protected function getExplodedNamespace()
    {
        return explode('\\', get_class($this));
    }

    /**
     * set the namespace for the views
     *
     * @return void
     */
    private function setNamespace()
    {
        $exploded_namespace = $this->getExplodedNamespace();
        $this->namespace    = Str::snake($exploded_namespace[0]) . '#' . Str::snake($exploded_namespace[1]);
    }

    /**
     * get the namespace of the views
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * set the directory that will contain the views files from an array
     *
     * @param int $offset
     * @return void
     */
    private function setDirectory($offset = 4)
    {
        $array = array_slice($this->getExplodedNamespace(), $offset);

        foreach ($array as $key => $value) {
            if ($key == count($array) - 1) {
                $this->directory .= str_replace('_controller', '', Str::snake($value));
            } else {
                $this->directory .= Str::snake($value) . '.';
            }
        }
    }

    /**
     * get the directory
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * set the full path to the view directory
     *
     * @param null|string $directory
     * @param null|string $namespace
     * @return void
     */
    protected function setPath($directory = null, $namespace = null)
    {
        $this->namespace = $namespace ?? $this->namespace;
        $this->directory = $directory ?? $this->directory;
        $this->path      = $this->namespace . '::' . $this->directory . '.';
    }

    /**
     * get the full path of the view
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * setup the view (full path before the view name & sharing general vars)
     *
     * @return void
     */
    private function setupView()
    {
        $this->setNamespace();
        $this->setDirectory();
        $this->setPath();
    }
}
