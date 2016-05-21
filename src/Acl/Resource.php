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
 * @category  Resource
 * @package   Jnjxp\Cheka
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      https://github.com/jnjxp/jnjxp.cheka
 */

namespace Jnjxp\Cheka\Acl;

use Jnjxp\Cheka\ResourceRouteAwareTrait;

use Aura\Router\Route;
use Zend\Permissions\Acl\Resource\ResourceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Resource
 *
 * @category Resource
 * @package  Jnjxp\Cheka
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/2016 MIT License
 * @link     https://github.com/jnjxp/jnjxp.cheka
 *
 * @see ResourceInterface
 */
class Resource implements ResourceInterface
{
    use ResourceRouteAwareTrait;

    /**
     * Request
     *
     * @var Request
     *
     * @access protected
     */
    protected $request;

    /**
     * Route
     *
     * @var Route
     *
     * @access protected
     */
    protected $route;

    /**
     * Create a RouteRequestResource
     *
     * @param Route   $route   Route
     * @param Request $request Request
     *
     * @access public
     */
    public function __construct(Route $route, Request $request)
    {
        $this->route = $route;
        $this->request = $request;
    }

    /**
     * Get resource id
     *
     * @return string
     *
     * @access public
     */
    public function getResourceId()
    {
        return $this->getResourceIdFromRoute($this->route);
    }

    /**
     * Get request
     *
     * @return Request
     *
     * @access public
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get route
     *
     * @return route
     *
     * @access public
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Magic property getter
     *
     * @param string $key name of property
     *
     * @return mixed
     *
     * @access public
     */
    public function __get($key)
    {
        return $this->$key;
    }
}
