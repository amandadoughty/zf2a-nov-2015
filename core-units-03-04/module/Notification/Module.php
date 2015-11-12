<?php
/**
 * This module demonstrates putting all critical code into a single file
 * (except for a separate lightweight Event class
 */
namespace Notification;

use Zend\Mvc\MvcEvent;
use Zend\Mail\Message;
use Zend\Mail\Transport;

class Module
{
    
    const NOTIFICATION_EVENT_NOTIFY     = 'notification.event.notify';
    const NOTIFICATION_EVENT_IDENTIFIER = 'notification.event.identifier';
    
    public function onBootstrap(MvcEvent $e)
    {
        $shared = $e->getApplication()->getEventManager()->getSharedManager();        
        // uses an identifier to "channel" which event managers are allowed to trigger this event
        // if you want to allow *any* event manager instance to trigger, change the 1st param to "*"
        $shared->attach('*',
                        self::NOTIFICATION_EVENT_NOTIFY,
                        [$this, 'sendNotification']);
    }
    
    public function getServiceConfig()
    {
        return [
            'services' => [
                'notification-email-info' => [
                    'to'	  => 'admin@company.com',
                    'from'	  => 'market@company.com',
                    'dir'	  => realpath(__DIR__ . '/../../data/email'),
                    'subject' => 'Thanks for Posting to the Online Market!',
                ],
            ],
            'factories' => [
                'notification-email-transport' => function ($sm) {
                    $emailInfo = $sm->get('notification-email-info');
                    // file transport is used for testing and development
                    $options   = new Transport\FileOptions(['path' => $emailInfo['dir']]);
                    $transport = new Transport\File($options);
                    // uncomment line below for production
                    //$transport = new Transport\Sendmail();
                    return $transport;
                }
            ],  
        ];
    }
    
	/**
	 * Sends email notification
	 * NOTE: when triggering this event, you need to supply these params:
	 *       delCode        = string delete code
	 *       serviceManager = an instance of "the" service manager
	 * @param EventInterface $e
	 */
	 public function sendNotification($e) 
	 {
		// send confirmation email with edit/delete code
        $sm        = $e->getParam('serviceManager');
		$message   = new Message();
        $transport = $sm->get('notification-email-transport');
        $emailInfo = $sm->get('notification-email-info');
        $delCode   = $e->getParam('delCode');
		// get "to" and "from" information from "email-info" service defined in email.local.php
		$message->addTo($emailInfo['to'])
			    ->addFrom($emailInfo['from'])
		        ->setSubject($emailInfo['subject'])
		        ->setBody('To edit or delete your posting use this key: ' . $delCode)
		        ->setEncoding('utf-8');
		$transport->send($message);
	}

}
