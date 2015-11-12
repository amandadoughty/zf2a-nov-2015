<?php
namespace Market\Model;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ListingsTableInitializer implements InitializerInterface
{
    public function initialize($instance, ServiceLocatorInterface $sl)
    {
        if ($instance instanceof ListingsTableAwareInterface) {
            $instance->setListingsTable($sl->getServiceLocator()->get('listings-table'));
        }
    }
}