<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonMarket for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Market;

use Zend\Crypt\BlockCipher;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Log;
use Zend\Form\Element\Text;
use Zend\Validator\CreditCard;
use Zend\InputFilter\Input;
use Zend\Filter\StripTags;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        // log items people view
	    $eventManager->attach('dispatch', array($this, 'onDispatch'), 100);
	    // user registration
	    $shared = $eventManager->getSharedManager();
	    $shared->attach('*', 'register', [$this, 'onSaveUser']);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
	public function onDispatch(MvcEvent $e)
	{
		// get routing information
	 	$matches    = $e->getRouteMatch();
	 	$controller = $matches->getParam('controller');
	 	$action		= $matches->getParam('action');
	 	// get params
        $params = $e->getApplication()->getServiceManager()->get('params');
	 	// log items viewed
		if ($controller == 'market-view-controller' && $action == 'item') {
			$id = $matches->getParam('id');
			$message = 'Item Viewed: ' . $id;
			// make sure the app has "write" rights to the log file
			$writer = new Log\Writer\Stream($params['log']);
			$formatter = new Log\Formatter\Simple('%timestamp% | %message%');
			$writer->setFormatter($formatter);
			$logger = new Log\Logger();
			$logger->addWriter($writer);
			$logger->info($message);		
		}
	}
	
	public function onSaveUser($e)
	{
	    $user = $e->getParam('user');      // our User entity
	    $sm   = $e->getTarget()->getServiceManager();
	    $user->setCcnumber($sm->get('market-block-cipher')->encrypt($user->getCcnumber()));
	}
	
	public function getServiceConfig()
	{
	    return [
	        'services' => [
	            'market-key' => 'Super Secret Key!!!???',
	        ],
	        'factories' => [
	            'market-element-ccnumber' => function ($sm) {
	                $element = new Text('ccnumber');
	                $element->setLabel('Enter CC Number');
	                return $element;
	            },
	            'market-input-ccnumber' => function ($sm) {
	                $input = new Input('ccnumber');
	                $input->getValidatorChain()
	                      ->attach(new CreditCard());
	                $input->getFilterChain()
	                      ->attach(new StripTags());
	                return $input;
	            },
	            'market-block-cipher' => function ($sm) {
	                $blockCipher = BlockCipher::factory('mcrypt', array('algo' => 'aes'));
	                $blockCipher->setKey($sm->get('market-key'));
	                return $blockCipher;
	            },
	        ],
	        'delegators' => [
	           'zfcuser_register_form' => [
	               function ($sm, $name, $requestedName, $callback) {
	                   $form = $callback();
	                   $form->add($sm->get('market-element-ccnumber'));
	                   $form->getInputFilter()->add($sm->get('market-input-ccnumber'));
                       return $form;
	               },
	           ],
	        ],
	    ];
	}
}
