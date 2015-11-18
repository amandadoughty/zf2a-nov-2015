<?php

namespace Market\Factory;

use Market\Controller\PostController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllers)
    {
        $allServices = $controllers->getServiceLocator();
        $sm = $allServices->get('ServiceManager');
    	$controller = new PostController();
        $controller->setListingsTable($sm->get('listings-table'));
        $controller->setCityCodesTable($sm->get('city-codes-table'));
        $controller->setPostForm($sm->get('post-form'));
        $controller->setPostFormFilter($sm->get('post-form-filter'));
        $controller->setMailTransport($sm->get('mail-transport'));
        $controller->setEmailInfo($sm->get('email-info'));
        $controller->setParams($sm->get('params'));
        $controller->setCategories($sm->get('categories'));
        return $controller;
    }
}
