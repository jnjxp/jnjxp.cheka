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

namespace Jnjxp\Cheka\Acl;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;

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
        $this->init($di->get('jnjxp/cheka:acl'));
    }

    /**
     * Init
     *
     * @param Acl $acl DESCRIPTION
     *
     * @return mixed
     *
     * @access protected
     */
    protected function init(Acl $acl)
    {
        $acl;
    }
}
