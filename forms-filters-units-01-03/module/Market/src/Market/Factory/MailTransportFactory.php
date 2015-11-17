<?php
namespace Market\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mail\Transport;

class MailTransportFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
    	// see module.config.php
        $emailInfo = $services->get('email-info');
        // file transport is used for testing and development
        $transport = new Transport\File(new Transport\FileOptions(array('path' => $emailInfo['dir'])));
        // uncomment line below for production
        //$transport = new Transport\Sendmail();
        return $transport;
    }
}
