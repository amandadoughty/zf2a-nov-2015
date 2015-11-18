<?php

namespace Market\Factory;

use Market\Controller\ViewController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ViewControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllers)
    {
        $allServices = $controllers->getServiceLocator();
        $sm = $allServices->get('ServiceManager');
        $controller = new ViewController();
        $controller->setListingsTable($sm->get('listings-table'));
        $controller->setCategories($sm->get('categories'));
        return $controller;
    }
}
