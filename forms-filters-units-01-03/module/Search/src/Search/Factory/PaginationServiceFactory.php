<?php
namespace Search\Factory;

use Search\Service\PaginationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PaginationServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
		$service = new PaginationService();
		$service->setListingsTable($sm->get('search-listings-table'));
		$service->setConfig($sm->get('search-pagination-config'));
		return $service;
    }
}
