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
 * @category  Responder
 * @package   Jnjxp\Cheka
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      https://github.com/jnjxp/jnjxp.cheka
 */

namespace Jnjxp\Cheka\Responder;

use Jnjxp\Cheka\RoleRequestAwareTrait;
use Jnjxp\Cheka\ResourceRouteAwareTrait;

use Aura\Router\Route;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * AbstractResponder
 *
 * @category Responder
 * @package  Jnjxp\Cheka
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/ MIT License
 * @link     https://github.com/jnjxp/jnjxp.cheka
 *
 * @abstract
 */
abstract class AbstractResponder
{
    use RoleRequestAwareTrait;
    use ResourceRouteAwareTrait;

    /**
     * PSR7 Request
     *
     * @var Request
     *
     * @access protected
     */
    protected $request;

    /**
     * PSR7 Response
     *
     * @var Response
     *
     * @access protected
     */
    protected $response;

    /**
     * Failed Route
     *
     * @var Route
     *
     * @access protected
     */
    protected $route;

    /**
     * __invoke
     *
     * @param Request  $request  DESCRIPTION
     * @param Response $response DESCRIPTION
     * @param Route    $route    DESCRIPTION
     *
     * @return mixed
     *
     * @access public
     */
    public function __invoke(Request $request, Response $response, Route $route)
    {
        $this->request  = $request;
        $this->response = $response;
        $this->route    = $route;

        $this->notAuthorized();

        return $this->response;
    }

    /**
     * GetMessage
     *
     * @return mixed
     *
     * @access protected
     */
    protected function getAuthorizationMessage()
    {
        $role      = $this->getRole($this->request)->getRoleId();
        $resource  = $this->getResourceIdFromRoute($this->route);
        $privilege = $this->getPrivilegeFromRoute($this->route);

        $needed = $privilege
            ? sprintf('"%s" privilege', $privilege)
            : 'privileges';

        return sprintf(
            '"%s" does not have %s on "%s"',
            $role,
            $needed,
            $resource
        );
    }

    /**
     * Not Authorized
     *
     * @return Response
     *
     * @access protected
     */
    abstract protected function notAuthorized();
}
