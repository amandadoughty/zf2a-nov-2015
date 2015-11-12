<?php
namespace Market\Model;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\InitializerInterface;

class ListingsTableAwareInitializer implements InitializerInterface
{
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof ListingsTableAwareInterface) {
            $listingsTable = $serviceLocator->getServiceLocator()->get('listings-table');
            $instance->setListingsTable($listingsTable);
        }
    }
}
