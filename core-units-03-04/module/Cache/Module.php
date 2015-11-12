<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Cache for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cache;

use Zend\Cache\StorageFactory;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController;

class Module
{
    
    const CACHE_EVENT_CLEAR      = 'cache.event.clear';
    const CACHE_EVENT_IDENTIFIER = 'cache.event.identifier';
    protected $cacheKey;
    
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        
        // MVC event
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'outputFromCache'), 100);
        $eventManager->attach(MvcEvent::EVENT_FINISH,   array($this, 'outputToCache'), 100);
        
        // shared events
        $shared = $eventManager->getSharedManager();
        // '*' allows *any* event manager instance to trigger
        $shared->attach('*',
        // use the line below if you want to control which event managers can trigger
        //$shared->attach(self::CACHE_EVENT_IDENTIFIER,
                        self::CACHE_EVENT_CLEAR,
                        array($this, 'onClear'));
    }

    public function outputFromCache(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $flag       = $routeMatch->getParam('cache');
        if ($flag) {
            $sm = $e->getApplication()->getServiceManager();
            $cache = $sm->get('cache-instance');
            $output = $cache->getItem($this->getCacheKey($routeMatch));
            if ($output) {
                return $output;
            } else {
                // this tells us to store output in cache upon finish
                $routeMatch->setParam('refresh', TRUE);
            }
        }
    }

    /**
     * Builds a unique cache key based on all params passed
     * 
     * @param RouteMatch $routeMatch
     * @return string $cacheKey
     */
    protected function getCacheKey($routeMatch)
    {
        if (!$this->cacheKey) { 
            $this->cacheKey = __NAMESPACE__;
            $params = $routeMatch->getParams();
            if (is_array($params)) {
                foreach ($params as $item) {
                    if (is_string($item)) {
                        $this->cacheKey .= '_' . $item;
                    }
                }                
            } else {
                $this->cacheKey = $params;
            }
            $this->cacheKey = preg_replace('/[^A-Z0-9_]/i', '', $this->cacheKey);
        }
        return $this->cacheKey;
    }

    public function outputToCache(MvcEvent $e) 
    {
        $routeMatch = $e->getRouteMatch();
        $flag       = $routeMatch->getParam('refresh');
        if ($flag) {
            $sm = $e->getApplication()->getServiceManager();
            $cache = $sm->get('cache-instance');
            $cache->setItem($this->getCacheKey($routeMatch), $e->getResponse());
        }
    }
    
    public function onClear($e)
    {
        $controller = $e->getTarget();      // controller instance
        if (!$controller instanceof AbstractActionController) {
            throw new \Exception('CACHE MODULE ERROR: Must be a controller instance!');
        }
        $event = $controller->getEvent();
        $routeMatch = $event->getRouteMatch();
        $sm = $controller->getServiceLocator();
        $cache = $sm->get('cache-instance');
        $cache->removeItem($this->getCacheKey($routeMatch));
    }
    
    public function getServiceConfig()
    {
        return [
            'services' => [
                'cache-config' => [
                    'adapter' => [
                        'name'      => 'filesystem',
                        'options'   => ['ttl' => 3600, 
                                        'cache_dir' => __DIR__ . '/../../data/cache'], 
                    ],
                    'plugins' => [
                        // override this on production server to FALSE
                        'exception_handler' => ['throw_exceptions' => TRUE],
                    ],
                ],
            ],
            'factories' => [
                'cache-instance' => function ($sm) {
                    return StorageFactory::factory($sm->get('cache-config'));
                },
            ],
        ];
    }
}
