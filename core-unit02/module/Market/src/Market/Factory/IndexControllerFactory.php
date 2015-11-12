<?php

namespace Market\Factory;

use Market\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllers)
    {
        $allServices = $controllers->getServiceLocator();
        $sm = $allServices->get('ServiceManager');
        $controller = new IndexController();
        //$controller->setListingsTable($sm->get('listings-table'));
        return $controller;
    }
}
