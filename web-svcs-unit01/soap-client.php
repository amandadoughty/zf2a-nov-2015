<?php

include __DIR__ . '/real.basic.autoload.php';
use Zend\Soap\Client;

// Modify the endpoint as necessary
$client = new Client('http://localhost:8080/soap.php');

// Modify '$original' to test encoding
$original = 'Hello world!';
echo "Unencoded '$original': ";
echo $client->encode($original), "\n";

// Modify '$encoded' to test decoding
$encoded = str_rot13('Hello world!');
echo "Encoded '$encoded': ";
echo $client->decode($encoded), "\n";
