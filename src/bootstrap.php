<?php

require 'core/Autoloader.php';

$loader = new Autoloader();
$loader->setDir(__DIR__ . '/core');
$loader->setDir(__DIR__ . '/controller');
$loader->register();
