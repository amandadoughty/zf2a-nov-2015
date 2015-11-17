<?php

namespace Search\Factory;

use Search\Controller\SearchController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SearchControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $sm = $services->getServiceLocator();
        $controller = new SearchController();
        $controller->setListingsTable($sm->get('search-listings-table'));
        $controller->setSearchForm($sm->get('search-form'));
        $controller->setSearchFormFilter($sm->get('search-form-filter'));
        $controller->setCategories($sm->get('categories'));
        $controller->setPaginationService($sm->get('search-pagination-service'));
        $controller->setPaginationConfig($sm->get('search-pagination-config'));
        return $controller;
    }
}
