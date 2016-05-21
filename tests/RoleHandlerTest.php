<?php
// @codingStandardsIgnoreFile

namespace Jnjxp\Cheka;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

use Aura\Auth\Auth;
use Fusible\AuthRole\Auth as AuthRole;

class RoleHandlerTest extends \PHPUnit_Framework_TestCase
{
    protected $request;
    protected $resource;
    protected $handler;

    public function setUp()
    {
        parent::setUp();

        $this->request = ServerRequestFactory::fromGlobals();
        $this->handler = new RoleHandler();
        $this->next = function ($req) {
            return $req;
        };
    }

    protected function runHandler()
    {
        $handler = $this->handler;
        return $handler($this->request, new Response, $this->next);
    }

    public function testNoAuth()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->runHandler();
    }

    public function testCustomFactory()
    {
        $role = $this->getMock(RoleInterface::class);
        $test = $this;
        $req  = $this->request;

        $factory = function ($request) use ($role, $req, $test) {
            $test->assertSame($request, $req);
            return $role;
        };

        $this->handler = new RoleHandler($factory);
        $this->handler->setRoleAttribute('role');

        $output = $this->runHandler();
        $this->assertSame($role, $output->getAttribute('role'));
    }

    public function testDecorated()
    {
        $auth = $this->getMockBuilder(Auth::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->request = $this->request->withAttribute('auth', $auth);
        $this->handler->setAuthAttribute('auth');
        $this->handler->setRoleAttribute('role');


        $output = $this->runHandler();
        $role = $output->getAttribute('role');

        $this->assertInstanceOf(Acl\Role::class, $role);
        $this->assertSame($auth, $role->getAuth());
    }

    public function testAuthIsRole()
    {
        $auth = $this->getMockBuilder(AuthRole::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->request = $this->request->withAttribute('auth', $auth);
        $this->handler->setAuthAttribute('auth');
        $this->handler->setRoleAttribute('role');

        $output = $this->runHandler();
        $role = $output->getAttribute('role');

        $this->assertSame($auth, $role);
    }
}
