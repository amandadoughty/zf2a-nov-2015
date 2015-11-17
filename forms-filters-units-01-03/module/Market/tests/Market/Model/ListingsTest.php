<?php

require_once 'PHPUnit/Framework/TestCase.php';
use Zend\ServiceManager\ServiceManager;

class ListingsTest extends PHPUnit_Framework_TestCase 
{
	private $adapter;
	private $table;
	private $serviceManager;
	
	public function setup()
	{
		parent::setUp ();
		$this->serviceManager = new ServiceManager();
		$moduleConfig = require APP_ROOT . '/module/Market/config/module.config.php';
		$localDbConfig = require APP_ROOT . '/config/autoload/db.local.php';
		$this->serviceManager->setService('Config', $localDbConfig);
		$this->serviceManager->setFactory('general-adapter', 'Zend\Db\Adapter\AdapterServiceFactory');
		$this->serviceManager->setFactory('listings-table-factory', 'Market\Factory\ListingsTableFactory');
		$this->adapter = $this->serviceManager->get('general-adapter');
		$this->table = $this->serviceManager->get('listings-table-factory');
	}
	public function teardown()
	{
	}

	public function testAdapter()
	{
		$this->assertInstanceOf('Zend\Db\Adapter\Adapter', $this->adapter);
	}
	
	public function testTableInstance()
	{
		$this->assertInstanceOf('Market\Model\ListingsTable', $this->table);
	}
}
