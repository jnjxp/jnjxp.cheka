<?php
// @codingStandardsIgnoreFile

namespace Jnjxp\Cheka\Route;

use Zend\Permissions\Acl\Resource\ResourceInterface;

class RouteTest extends \PHPUnit_Framework_TestCase
{

    public function testRoute()
    {
        $route = new Route;
        $resource = 'resource';
        $privilege = 'privilege';

        $route
            ->setResourceIdKey('res')
            ->resource($resource)
            ->privilege($privilege);

        $this->assertSame($resource, $route->getResourceId());

        $expected = [
            'res' => $resource,
            'privilege' => $privilege
        ];

        $this->assertSame($expected, $route->extras);

        $this->assertInstanceOf(ResourceInterface::class, $route);
        $this->assertInstanceOf(ResourceInterface::class, new RadarRoute);
    }
}
