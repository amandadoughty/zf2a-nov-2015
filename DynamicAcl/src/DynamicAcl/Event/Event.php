<?php
// 2015-03-11 DB
namespace DynamicAcl\Event;

use Zend\EventManager\Event as ZendEvent;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class Event extends ZendEvent implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    const DYNAMIC_ACL_MENU_EVENT = 'dynamic.acl.menu.event';
    const DYNAMIC_ACL_CHANNEL    = 'dynamic.acl.channel';
}
