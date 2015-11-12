<?php
namespace Market\Factory;

use Market\Model\CityCodesTable;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;

class CityCodesTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
    	// see /path/to/onlinemarket/config/autoload/db.local.php
        $adapter   = $services->get('general-adapter');
        return new CityCodesTable('world_city_area_codes', $adapter);
    }
}
