<?php

include __DIR__ . '/real.basic.autoload.php';

use Zend\XmlRpc\Client;

//include __DIR__ . '/vendor/autoload.php';

// Modify the endpoint as necessary
$client  = new Client('http://localhost:8080/xml-rpc.php');
$service = $client->getProxy();

// Modify '$original' to test encoding
$original = 'Hello world!';
echo "Unencoded '$original': ";
echo $service->rot13->encode($original), "\n";

// Modify '$encoded' to test decoding
$encoded = str_rot13('Hello world!');
echo "Encoded '$encoded': ";
echo $service->rot13->decode($encoded), "\n";
