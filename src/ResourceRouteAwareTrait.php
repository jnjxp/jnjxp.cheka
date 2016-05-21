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

namespace Jnjxp\Cheka;

use Aura\Router\Route;

/**
 * Route resource aware trait
 *
 * @category Resource
 * @package  Jnjxp\Cheka
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/2016 MIT License
 * @link     https://github.com/jnjxp/jnjxp.cheka
 */
trait ResourceRouteAwareTrait
{
    /**
     * Key on which resourceId is stored in extras
     *
     * @var string
     *
     * @access protected
     */
    protected $resourceIdKey = 'resource';

    /**
     * Key on which privilege is stored in extras
     *
     * @var string
     *
     * @access protected
     */
    protected $privilegeKey = 'privilege';

    /**
     * Set extras key on which resourceId is stored
     *
     * @param string $key name of offset
     *
     * @return $this
     *
     * @access public
     */
    public function setResourceIdKey($key)
    {
        $this->resourceIdKey = $key;
        return $this;
    }

    /**
     * Set extras key on which privilege is stored
     *
     * @param string $key name of offset
     *
     * @return $this
     *
     * @access public
     */
    public function setPrivilegeKey($key)
    {
        $this->privilegeKey = $key;
        return $this;
    }

    /**
     * Get resourceId from Route
     *
     * @param Route $route Route
     *
     * @return string|null
     *
     * @access protected
     */
    protected function getResourceIdFromRoute(Route $route)
    {
        $extras = $route->extras;

        return isset($extras[$this->resourceIdKey])
            ? $extras[$this->resourceIdKey]
            : null;
    }

    /**
     * Get privilege from route
     *
     * @param Route $route Route
     *
     * @return null|string
     *
     * @access protected
     */
    protected function getPrivilegeFromRoute(Route $route)
    {
        $extras = $route->extras;

        return isset($extras[$this->privilegeKey])
            ? $extras[$this->privilegeKey]
            : null;
    }
}
