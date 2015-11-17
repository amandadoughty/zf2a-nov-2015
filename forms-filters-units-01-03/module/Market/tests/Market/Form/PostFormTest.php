<?php

require_once 'PHPUnit/Framework/TestCase.php';
use Zend\ServiceManager\ServiceManager;

class PostFormTest extends PHPUnit_Framework_TestCase 
{
	private $form;
	private $serviceManager;
	private $moduleConfig;
		
	public function setup()
	{
		parent::setUp ();
		$this->serviceManager = new ServiceManager();
		$this->moduleConfig = require APP_ROOT . '/module/Market/config/module.config.php';
		$localDbConfig = require APP_ROOT . '/config/autoload/db.local.php';
		$this->serviceManager->setService('Config', array_merge($this->moduleConfig, $localDbConfig));
		$this->serviceManager->setFactory('general-adapter', 'Zend\Db\Adapter\AdapterServiceFactory');
		$this->serviceManager->setFactory('city-codes-table', 'Market\Factory\CityCodesTableFactory');
		$this->serviceManager->setFactory('post-form', 'Market\Factory\PostFormFactory');
		$this->form = $this->serviceManager->get('post-form');
		//$this->table = $this->serviceManager->get('city-codes-table-factory');
	}
	public function teardown()
	{
		unset($this->form);
	}

	public function testFormInstance()
	{
		$this->assertInstanceOf('Market\Form\PostForm', $this->form);
	}
}
