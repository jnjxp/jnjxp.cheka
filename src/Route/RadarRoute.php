<?php
/**
 * Jnjxp Cheka - Authorization
 *
 * PHP version 5
 *
 * Copyright (C) 2016 Jake Johns
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 *
 * @category  Route
 * @package   Jnjxp\Cheka
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      https://github.com/jnjxp/jnjxp.cheka
 */

namespace Jnjxp\Cheka\Route;

use Radar\Adr\Route as BaseRoute;
use Zend\Permissions\Acl\Resource\ResourceInterface;

/**
 * Route
 *
 * @category Route
 * @package  Jnjxp\Cheka
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/ MIT License
 * @link     https://github.com/jnjxp/jnjxp.cheka
 *
 * @see ResourceInterface
 * @see BaseRoute
 */
class RadarRoute extends BaseRoute implements ResourceInterface
{
    use RouteResourceTrait;
}
