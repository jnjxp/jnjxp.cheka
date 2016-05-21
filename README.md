# jnjxp.cheka
Cheka: Route based ACL for Aura\Route and Radar\Adr

[![Latest version][ico-version]][link-packagist]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]

## Installation
```
composer install jnjxp/cheka
```

## Usage

`Jnjxp\Cheka\Config` will `setRouteFactory()` on `Aura\Router\RouterContainer`
so as to use `Jnjxp\Cheka\Route\RadarRoute`.

It will also set the service `jnjxp/cheka:acl` as an instance of
`Zend\Permissions\Acl\Acl` which will be passed to `Jnjxp\Cheka\AuthorizedRule`.

`Jnjxp\Cheka\AuthorizedRule` will be appended to
`Aura\Router\Rule\RuleIterator`.

```php
$adr = $boot->adr(
    //...,
    Jnjxp\Cheka\Config::class,
    MyConfig::class
);
```

You'll want to configure your Acl. `Jnjxp\Cheka\Acl\Config` might help.
```php
use Jnjxp\Cheka\Acl\Config as AclConfig;
use Zend\Permissions\Acl\Acl;

class MyConfig extends AclConfig
{
    protected $resources = ['resource'];
    protected $roles = ['guest', 'user'];

    protected function init(Acl $acl)
    {
        foreach ($this->resources as $resource) {
            $acl->addResource($resource);
        }

        foreach ($this->roles as $role) {
            $acl->addRole($role);
        }

        $acl->allow('guest', 'resource', 'read');
        $acl->allow('user', 'resource');
    }
}
```

When defining routes, you can designate a 'Resource' and a 'Privilege'.

```php

$adr->get('Action\Resource\Read', '/resource/{id}', Resource\Service\Read::class)
    ->resource('resource')
    ->privilege('read');

$adr->patch('Action\Resource\Edit', '/resource/{id}', Resource\Service\Edit::class)
    ->resource('resource')
    ->privilege('edit');

// note, under the hood these values are only stored in the `extras` property
// The following has the same effect, assuming you have not changed the keys
// under which these values are stored.

$adr->patch('Action\Resource\Edit', '/resource/{id}', Resource\Service\Edit::class)
    ->extras(['resource' => 'resource', 'privilege' => 'edit']);

```

You'll need to add the `RoleHandler` to the middleware stack as well.
Additionally, this is intended to work with Aura\Auth, so you'll probably need
something like this:

```php
$adr->middle(Vperyod\AuthHandler\AuthHandler::class);
// By default, the RoleHandler assumes there's an Aura\Auth object available in
// the request, so add the AuthHandler first, or modify it.
$adr->middle(Jnjxp\Cheka\RoleHandler::class);
```


[ico-version]: https://img.shields.io/packagist/v/jnjxp/cheka.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jnjxp/jnjxp.cheka/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/jnjxp/jnjxp.cheka.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/jnjxp/jnjxp.cheka.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/jnjxp/cheka
[link-travis]: https://travis-ci.org/jnjxp/jnjxp.cheka
[link-scrutinizer]: https://scrutinizer-ci.com/g/jnjxp/jnjxp.cheka
[link-code-quality]: https://scrutinizer-ci.com/g/jnjxp/jnjxp.cheka
