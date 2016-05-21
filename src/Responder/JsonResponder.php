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

/**
 * JsonResponder
 *
 * @category Responder
 * @package  Jnjxp\Cheka
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/ MIT License
 * @link     https://github.com/jnjxp/jnjxp.cheka
 *
 * @see AbstractResponder
 */
class JsonResponder extends AbstractResponder
{
    /**
     * Not Authorized
     *
     * @return Response
     *
     * @access protected
     */
    protected function notAuthorized()
    {
        $data = ['error' => $this->getAuthorizationMessage()];

        $this->response = $this->response
            ->withStatus(403)
            ->withHeader('Content-Type', 'application/json');

        $this->response->getBody()->write(json_encode($data));
    }
}
