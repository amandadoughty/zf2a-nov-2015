<?php
namespace Application\Service;

use Zend\Log;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogFactory implements FactoryInterface
{	
	public function createService(ServiceLocatorInterface $serviceLocator) 
	{
	    // get params
	    $params = $serviceLocator->get('params');
	    
	    $writer = new Log\Writer\Stream($params['log']);
	    $formatter = new Log\Formatter\Simple('%timestamp% | %message%');
	    $writer->setFormatter($formatter);
	    $logger = new Log\Logger();
	    $logger->addWriter($writer);
	    
	    return $logger;
	}
}