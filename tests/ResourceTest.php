<?php
// @codingStandardsIgnoreFile

namespace Jnjxp\Cheka;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Permissions\Acl\Resource\ResourceInterface;

class RouteTest extends \PHPUnit_Framework_TestCase
{

    public function testResource()
    {
        $route = new Route\Route;
        $request = ServerRequestFactory::fromGlobals();

        $resource = new Acl\Resource($route, $request);

        $this->assertInstanceOf(ResourceInterface::class, $resource);

        $this->assertSame($route, $resource->route);
        $this->assertSame($route, $resource->getRoute());

        $this->assertSame($request, $resource->request);
        $this->assertSame($request, $resource->getRequest());
    }
}
