<?php
/**
 * Cheka - Authorization
 *
 * PHP version 5
 *
 * Copyright (C) 2016 Jake Johns
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 *
 * @category  Router
 * @package   Jnjxp\Cheka
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      https://github.com/jnjxp/jnjxp.cheka
 */

namespace Jnjxp\Cheka;

use Aura\Router\Rule\RuleInterface;
use Aura\Router\Route;

use Zend\Permissions\Acl\AclInterface;
use Zend\Permissions\Acl\Resource\ResourceInterface;

use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Require Authorization based on ACL
 *
 * @category Router
 * @package  Jnjxp\Cheka
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/2016 MIT License
 * @link     https://github.com/jnjxp/jnjxp.cheka
 *
 * @see RuleInterface
 */
class AuthorizedRule implements RuleInterface
{
    use ResourceRouteAwareTrait;
    use RoleRequestAwareTrait;

    /**
     * Acl
     *
     * @var AclInterface
     *
     * @access protected
     */
    protected $acl;

    /**
     * Resource factory
     *
     * @var callable
     *
     * @access protected
     */
    protected $resourceFactory;

    /**
     * Create an ACL router rule
     *
     * @param AclInterface $acl Configured acl to check against
     *
     * @access public
     */
    public function __construct(AclInterface $acl)
    {
        $this->acl = $acl;
        $this->resourceFactory = [$this, 'newResource'];
    }

    /**
     * Set resource factory
     *
     * @param callable $factory to create resource from Route and Request
     *
     * @return $this
     *
     * @access public
     */
    public function setResourceFactory(callable $factory)
    {
        $this->resourceFactory = $factory;
        return $this;
    }

    /**
     * Check that role has access to routes resource and privilege
     *
     * @param Request $request PSR7 Server Request
     * @param Route   $route   Route
     *
     * @return bool
     *
     * @access public
     */
    public function __invoke(Request $request, Route $route)
    {
        $factory = $this->resourceFactory;
        $resource = $factory($route, $request);

        if ($this->isWhitelisted($resource)) {
            return true;
        }

        $role = $this->getRole($request);
        $privilege = $this->getPrivilegeFromRoute($route);

        return $this->acl->isAllowed($role, $resource, $privilege);
    }

    /**
     * Is Whitelisted?
     *
     * @param ResourceInterface $resource Route resource
     *
     * @return bool
     *
     * @access protected
     */
    protected function isWhitelisted(ResourceInterface $resource)
    {
        if (! $resource->getResourceId()) {
            return true;
        }
        return false;
    }

    /**
     * New resource from Route and Request
     *
     * @param Route   $route   Route
     * @param Request $request Request
     *
     * @return RouteRequestResource
     *
     * @access protected
     */
    protected function newResource(Route $route, Request $request)
    {
        return new Acl\Resource($route, $request);
    }
}
