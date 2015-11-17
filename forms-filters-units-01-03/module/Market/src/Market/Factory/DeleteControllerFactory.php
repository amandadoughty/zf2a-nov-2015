<?php

namespace Market\Factory;

use Market\Controller\DeleteController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DeleteControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllers)
    {
        $allServices = $controllers->getServiceLocator();
        $sm = $allServices->get('ServiceManager');
    	$controller = new DeleteController();
        $controller->setListingsTable($sm->get('listings-table'));
        $controller->setDeleteForm($sm->get('delete-form'));
        $controller->setDeleteFormFilter($sm->get('delete-form-filter'));
        return $controller;
    }
}
