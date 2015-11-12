<?php
use Market\Module;
error_reporting( E_ALL | E_STRICT );
define('APP_ROOT', realpath(__DIR__ .'/../../..'));
define('ZF2_LIBRARY',realpath(APP_ROOT . '/vendor/ZF2/library'));
$path = array(ZF2_LIBRARY, __DIR__, get_include_path(),);
set_include_path(implode(PATH_SEPARATOR, $path));

require_once ZF2_LIBRARY . '/Zend/Loader/StandardAutoloader.php';
use Zend\Loader\StandardAutoloader as StandardAutoloader;

$autoloader = new StandardAutoloader();
$autoloader->register();

require_once 'Zend/Loader/AutoloaderFactory.php';
require_once '../Module.php';
$module = new Module();
$config = $module->getAutoloaderConfig();
$config['Zend\Loader\StandardAutoloader']['namespaces']['Zend'] = ZF2_LIBRARY . '/Zend';
$config['Zend\Loader\StandardAutoloader']['namespaces']['ZendTest'] = ZF2_LIBRARY . '/ZendTest';
$config['Zend\Loader\StandardAutoloader']['namespaces']['Market'] = __DIR__ . '/../src';
Zend\Loader\AutoloaderFactory::factory($config);
