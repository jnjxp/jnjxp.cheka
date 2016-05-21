<?php
// @codingStandardsIgnoreFile

namespace Jnjxp\Cheka;

use Aura\Di\AbstractContainerConfigTest;

use Zend\Permissions\Acl\Acl;

use Jnjxp\Cheka\Acl\Config as AclConfig;

class ConfigTest extends AbstractContainerConfigTest
{
    protected function setUp()
    {
        @session_start();
        parent::setUp();
    }

    protected function getConfigClasses()
    {
        return [
            'Radar\Adr\Config',
            Config::class,
            AclConfig::class
        ];
    }

    public function provideGet()
    {
        return [
            ['jnjxp/cheka:acl', Acl::class],
        ];
    }

    public function provideNewInstance()
    {
        return [
            [AuthorizedRule::class],
            [RoleHandler::class],
        ];
    }

    public function testRoute()
    {
        $route = $this->di
            ->get('radar/adr:router')
            ->getRoute();

        $this->assertInstanceOf(Route\RadarRoute::class, $route);
    }
}

