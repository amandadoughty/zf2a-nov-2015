<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonMarket for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Market;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Log;

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
}
