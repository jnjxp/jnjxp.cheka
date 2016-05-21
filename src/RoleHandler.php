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
 * @category  Middleware
 * @package   Jnjxp\Cheka
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      https://github.com/jnjxp/jnjxp.cheka
 */

namespace Jnjxp\Cheka;

use Vperyod\AuthHandler\AuthRequestAwareTrait;
use Zend\Permissions\Acl\Role\RoleInterface;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Request Route Resource
 *
 * @category Resource
 * @package  Jnjxp\Cheka
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/2016 MIT License
 * @link     https://github.com/jnjxp/jnjxp.cheka
 *
 * @see ResourceInterface
 */
class RoleHandler
{
    use AuthRequestAwareTrait;
    use RoleRequestAwareTrait;

    /**
     * Role factory
     *
     * @var callable
     *
     * @access protected
     */
    protected $roleFactory;

    /**
     * Create a RoleHandler
     *
     * @param callable $roleFactory factory to create role from request
     *
     * @access public
     */
    public function __construct(callable $roleFactory = null)
    {
        $this->roleFactory = $roleFactory ?: [$this, 'newRole'];
    }

    /**
     * Add Role object to Request
     *
     * @param Request  $request  PSR7 Request
     * @param Response $response PSR7 Response
     * @param callable $next     next middleware
     *
     * @return Response
     *
     * @access public
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $factory = $this->roleFactory;

        $request = $request->withAttribute(
            $this->roleAttribute,
            $factory($request)
        );

        return $next($request, $response);
    }

    /**
     * Create a new Role from Auth stored in Request
     *
     * @param Request $request PSR7 Request
     *
     * @return Acl\Role
     *
     * @access protected
     */
    protected function newRole(Request $request)
    {
        $auth = $this->getAuth($request);
        if ($auth instanceof RoleInterface) {
            return $auth;
        }
        return new Acl\Role($auth);
    }
}
