<?php

include __DIR__ . '/real.basic.autoload.php';
require_once __DIR__ . '/Rot13.php';

use Zend\Http\PhpEnvironment\Request;
use Zend\Soap\AutoDiscover;
use Zend\Soap\Server;

$wsdl    = __DIR__ . '/zf2a.wsdl';
$uri     = 'http://localhost:8080/soap.php';
$request = new Request();

switch ($request->getMethod()) {
    case Request::METHOD_GET:
        if (!file_exists($wsdl)) {
            $server = new AutoDiscover();
            $server->setClass('Zf2AdvancedCourse\Rot13')
                ->setUri($uri)
                ->setServiceName('Rot13');
            $xml = $server->generate();
            file_put_contents($wsdl, $xml->toXml());
        }
        header('Content-Type: text/xml');
        readfile($wsdl);
        break;
    case Request::METHOD_POST:
        $server = new Server($uri);
        $server->setClass('Zf2AdvancedCourse\Rot13');
        $server->handle();
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
        exit(1);
}
