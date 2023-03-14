<?php

use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

define('APP_ROOT_DIRPATH', dirname(__DIR__, 1));

$containerBuilder = new ContainerBuilder;
// Load DI definitions from files
$containerBuilder->addDefinitions(__DIR__ . '/config.php');

$container = $containerBuilder->build();

return $container;
