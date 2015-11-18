<?php

use Zend\Crypt\Password\Bcrypt;

$bcrypt = new Bcrypt();
$securePass = 'the stored bcrypt value';
$password = 'the password to check';

if ($bcrypt->verify($password, $securePass)) {
        echo "The password is correct! \n";
} else {
        echo "The password is NOT correct.\n";
}

