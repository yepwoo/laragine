<?php

namespace Core\Base\Tests\Unit;

use Core\Base\Tests\TestCase;
use Core\Base\Controllers\Web\Controller;

class WebControllerTest extends TestCase
{
    /**
     * the web controller
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $controller;

    /**
     * setting up
     *
     * @throws \ReflectionException
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->controller = $this->getMockBuilder(Controller::class)
                                 ->disableOriginalConstructor()
                                 ->setMethods(['getExplodedNamespace'])
                                 ->getMock();

        $this->controller->expects($this->any())
                         ->method('getExplodedNamespace')
                         ->willReturn(['Core', 'Module', 'Controllers', 'Web', 'User', 'FakeCustomerController']);

        $controllerReflector = new \ReflectionClass($this->controller);
        $setupViewMethod     = $controllerReflector->getMethod('setupView');
        $setupViewMethod->setAccessible(true);
        $setupViewMethod->invoke($this->controller);
    }

    /**
     * test the namespace
     *
     * @return string
     */
    public function testNamespace()
    {
        $namespace = $this->controller->getNamespace();
        $this->assertEquals('core#module', $namespace);

        return $namespace;
    }

    /**
     * test the directory
     *
     * @return string
     */
    public function testDirectory()
    {
        $directory = $this->controller->getDirectory();
        $this->assertEquals('user.fake_customer', $directory);

        return $directory;
    }

    /**
     * test the path
     *
     * @param string $namespace
     * @param string $directory
     * @depends testNamespace
     * @depends testDirectory
     */
    public function testPath($namespace, $directory)
    {
        $this->assertEquals($namespace . '::' . $directory . '.', $this->controller->getPath());
    }
}
