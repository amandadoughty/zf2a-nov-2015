<?php
namespace Application\Controller;

use PhlyContact\Controller\ContactController as PhlyController;
class ContactController extends PhlyController
{
    protected $message;
    protected $transport;
    
    protected function sendEmail(array $data)
    {
        $serviceLocator       = $this->getServiceLocator();
        $this->message        = $serviceLocator->get('PhlyContactMailMessage');
        $this->transport      = $serviceLocator->get('PhlyContactMailTransport');
        parent::sendEmail($data);        
    }
}