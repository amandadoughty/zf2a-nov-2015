<?php

namespace Application\Factory;

use Application\Controller\ContactController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContactControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $serviceLocator = $services->getServiceLocator();
        $form           = $serviceLocator->get('PhlyContactForm');
        $controller = new ContactController();
        $controller->setContactForm($form);       
        return $controller;
    }
}
