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

namespace Jnjxp\Cheka\Route;

use Jnjxp\Cheka\ResourceRouteAwareTrait;

/**
 * Route resource trait
 *
 * @category Route
 * @package  Jnjxp\Cheka
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/ MIT License
 * @link     https://github.com/jnjxp/jnjxp.cheka
 */
trait RouteResourceTrait
{
    use ResourceRouteAwareTrait;

    /**
     * Get resourceId
     *
     * @return string|null
     *
     * @access public
     */
    public function getResourceId()
    {
        return $this->getResourceIdFromRoute($this);
    }

    /**
     * Set resourceId extra key
     *
     * @param string $resource resourceId
     *
     * @return $this
     *
     * @access public
     */
    public function resource($resource)
    {
        return $this->extras([$this->resourceIdKey => $resource]);
    }

    /**
     * Set privilege string
     *
     * @param string $privilege privilege to require
     *
     * @return $this
     *
     * @access public
     */
    public function privilege($privilege)
    {
        return $this->extras([$this->privilegeKey => $privilege]);
    }
}
