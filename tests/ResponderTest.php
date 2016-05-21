<?php
// @codingStandardsIgnoreFile

namespace Jnjxp\Cheka;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

use Zend\Permissions\Acl\Role\RoleInterface;

class ResponderTest extends \PHPUnit_Framework_TestCase
{

    protected $request;
    protected $response;
    protected $route;
    protected $responder;

    public function setUp()
    {
        $role = $this->getMock(RoleInterface::class);
        $role->expects($this->once())
            ->method('getRoleId')
            ->will($this->returnValue('role'));

        $this->request = ServerRequestFactory::fromGlobals()
            ->withAttribute('role', $role);

        $this->response = new Response;
        $this->route = new Route\Route;

        $this->route
            ->resource('res')
            ->privilege('priv');
    }

    protected function respond()
    {
        $responder = $this->responder;
        return $responder($this->request, $this->response, $this->route);
    }

    public function testJson()
    {
        $this->responder = new Responder\JsonResponder;
        $this->responder->setRoleAttribute('role');
        $response = $this->respond();

        $msg = '"role" does not have "priv" privilege on "res"';
        $body = json_encode(['error' => $msg]);
        $this->assertEquals($body, (string) $response->getBody());
    }
}
