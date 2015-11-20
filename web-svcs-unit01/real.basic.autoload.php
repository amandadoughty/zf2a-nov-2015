<?php
function __autoload($class) {
    $fn = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    require_once $fn;
}
