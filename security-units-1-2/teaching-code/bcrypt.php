<?php

use Zend\Crypt\Password\Bcrypt;

$password = 'user password';
$bcrypt = new Bcrypt();
$securePass = $bcrypt->create($password);

