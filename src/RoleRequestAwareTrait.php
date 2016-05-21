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
 * @category  Role
 * @package   Jnjxp\Cheka
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      https://github.com/jnjxp/jnjxp.cheka
 */

namespace Jnjxp\Cheka;

use Zend\Permissions\Acl\Role\RoleInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Get Role from Request
 *
 * @category Role
 * @package  Jnjxp\Cheka
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/2016 MIT License
 * @link     https://github.com/jnjxp/jnjxp.cheka
 */
trait RoleRequestAwareTrait
{
    /**
     * Attribute on which Role is stored in Request
     *
     * @var string
     *
     * @access protected
     */
    protected $roleAttribute = 'jnjxp/cheka:role';

    /**
     * Set attribute on which to store role
     *
     * @param string $attr name of attribute
     *
     * @return $this
     *
     * @access public
     */
    public function setRoleAttribute($attr)
    {
        $this->roleAttribute = $attr;
        return $this;
    }

    /**
     * Get role
     *
     * @param Request $request PSR7 Request
     *
     * @return RoleInterface
     *
     * @access protected
     */
    protected function getRole(Request $request)
    {
        $role = $request->getAttribute($this->roleAttribute);
        if (! $role instanceof RoleInterface) {
            throw new \InvalidArgumentException(
                'Role attribute not available in request'
            );
        }
        return $role;
    }
}
