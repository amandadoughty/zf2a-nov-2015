<?php

namespace Market\Factory;

use Market\Controller\PostController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllers)
    {
        
        $sm = $controllers->getServiceLocator();
    	$controller = new PostController();
        $controller->setCityCodesTable($sm->get('city-codes-table'));
        $controller->setPostForm($sm->get('post-form'));
        $controller->setPostFormFilter($sm->get('post-form-filter'));
        $controller->setParams($sm->get('params'));
        $controller->setCategories($sm->get('categories'));
        
        // done by an initializer
        //$controller->setListingsTable($sm->get('listings-table'));
        
        // done by the Notification module + triggering and event
        //$controller->setMailTransport($sm->get('mail-transport'));
        //$controller->setEmailInfo($sm->get('email-info'));
        
        return $controller;
    }
}
