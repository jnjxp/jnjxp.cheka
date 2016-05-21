<?php
// @codingStandardsIgnoreFile

namespace Jnjxp\Cheka;

use Aura\Router\Route;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

use Zend\Permissions\Acl\AclInterface;
use Zend\Permissions\Acl\Role\RoleInterface;
use Zend\Permissions\Acl\Resource\ResourceInterface;

class AuthorizedRuleTest extends \PHPUnit_Framework_TestCase
{
    protected $route;

    protected $acl;

    protected $auth;

    protected $request;

    protected $rule;

    protected $resource;

    public function setUp()
    {
        parent::setUp();

        $this->route = new Route;
        $this->acl = $this->getMock(AclInterface::class);
        $this->role = $this->getMock(RoleInterface::class);

        $this->request = ServerRequestFactory::fromGlobals()
            ->withAttribute('role', $this->role);

        $this->rule = new AuthorizedRule($this->acl);
        $this->rule->setRoleAttribute('role');
    }

    public function fakeResourceFactory($route, $req)
    {
        $this->assertSame($this->request, $req);
        $this->assertSame($this->route, $route);
        return $this->resource;
    }

    protected function checkRule()
    {
        $rule = $this->rule;
        return $rule($this->request, $this->route);
    }

    public function testNoRole()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->route->extras(['resource' => 'foo']);
        $this->request = ServerRequestFactory::fromGlobals();
        $this->checkRule();
    }

    public function testAuthorized()
    {
        $this->route->extras(
            [
                'resource' => 'foo',
                'privilege' => 'priv'
            ]
        );

        $this->acl
            ->expects($this->once())
            ->method('isAllowed')
            ->with(
                $this->role,
                $this->isInstanceOf(Acl\Resource::class),
                $this->equalTo('priv')
            )->will($this->returnValue(true));

        $this->assertTrue($this->checkRule());
    }

    public function testWhitelisted()
    {
        $this->assertTrue($this->checkRule());
    }

    public function testNotAuthorized()
    {
        $this->route->extras(
            [
                'resource' => 'foo',
                'privilege' => 'priv'
            ]
        );

        $this->acl
            ->expects($this->once())
            ->method('isAllowed')
            ->with(
                $this->role,
                $this->isInstanceOf(Acl\Resource::class),
                $this->equalTo('priv')
            )->will($this->returnValue(false));

        $this->assertFalse($this->checkRule());
    }

    public function testCustomResourceFactory()
    {
        $this->resource = $this->getMock(ResourceInterface::class);
        $this->resource->expects($this->once())
            ->method('getResourceId')
            ->will($this->returnValue('foo'));

        $this->rule->setResourceFactory([$this, 'fakeResourceFactory']);

        $this->acl
            ->expects($this->once())
            ->method('isAllowed')
            ->with(
                $this->role,
                $this->resource,
                $this->equalTo(null)
            )->will($this->returnValue(false));

        $this->assertFalse($this->checkRule());
    }

    public function testCustomPermission()
    {
        $this->route->extras(
            [
                'resource' => 'foo',
                'priv' => 'altPriv'
            ]
        );

        $this->rule->setPrivilegeKey('priv');

        $this->acl
            ->expects($this->once())
            ->method('isAllowed')
            ->with(
                $this->role,
                $this->isInstanceOf(Acl\Resource::class),
                $this->equalTo('altPriv')
            )->will($this->returnValue(false));

        $this->assertFalse($this->checkRule());
    }
}
