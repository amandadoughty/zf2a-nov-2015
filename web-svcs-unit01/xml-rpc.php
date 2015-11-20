<?php

require __DIR__ . '/real.basic.autoload.php';
require_once __DIR__ . '/Rot13.php';

use Zend\XmlRpc\Server;

$server = new Server();
$server->setClass('Zf2AdvancedCourse\Rot13', 'rot13');
echo $server->handle();
