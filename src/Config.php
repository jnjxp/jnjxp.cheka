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
 * @category  Config
 * @package   Jnjxp\Cheka
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      https://github.com/jnjxp/jnjxp.cheka
 */

namespace Jnjxp\Cheka;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;

use Aura\Router\RouterContainer;

use Zend\Permissions\Acl\Acl;

/**
 * Config
 *
 * @category Config
 * @package  Jnjxp\Cheka
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/2016 MIT License
 * @link     https://github.com/jnjxp/jnjxp.cheka
 *
 * @see ContainerConfig
 */
class Config extends ContainerConfig
{
    /**
     * Define
     *
     * @param Container $di Aura\Di Container
     *
     * @return void
     *
     * @access public
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function define(Container $di)
    {
        $di->setters[RouterContainer::class]['setRouteFactory'] = $di->newFactory(
            Route\RadarRoute::class
        );

        $di->set('jnjxp/cheka:acl', $di->lazyNew(Acl::class));

        $di->params[AuthorizedRule::class]['acl'] = $di->lazyGet('jnjxp/cheka:acl');
    }

    /**
     * Modify container
     *
     * @param Container $di DESCRIPTION
     *
     * @return mixed
     *
     * @access public
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function modify(Container $di)
    {
        $di->get('radar/adr:adr')
            ->rules()
            ->append($di->newInstance(AuthorizedRule::class));
    }
}
