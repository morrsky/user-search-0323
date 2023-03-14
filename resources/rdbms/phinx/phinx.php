<?php

use Symfony\Component\Dotenv\Dotenv;
use App\Application\Settings\ApplicationEnvironment;

define('APP_ROOT_DIRPATH', dirname(__DIR__ . '/../../../../', 1));

require APP_ROOT_DIRPATH . '/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(APP_ROOT_DIRPATH . '/.env');

$appSettings = require APP_ROOT_DIRPATH . '/app/settings.php';
$appEnv = new ApplicationEnvironment();
$dbSettings = $appSettings->get('database');

$driverProd = explode("_",$dbSettings['production']['driver']);
$driverDev = explode("_",$dbSettings['dev']['driver']);

return
[
    'paths' => [
        'migrations' => [
            './resources/rdbms/phinx/migrations/'
        ],
        'seeds' => [
            './resources/rdbms/phinx/seeds'
        ]
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => $appEnv(),
        'production' => [
            'adapter' => strtolower($driverProd[1]),
            'name' => $dbSettings['production']['name'],
            'user' => $dbSettings['production']['username'],
            'pass' => $dbSettings['production']['password'],
            'host' => $dbSettings['production']['host'],
            'prefix' => $dbSettings['production']['prefix'],
            'suffix' => $dbSettings['production']['suffix']
        ],
        'dev' => [
            'adapter' => strtolower($driverDev[1]),
            'name' => $dbSettings['dev']['name'],
            'user' => $dbSettings['dev']['username'],
            'pass' => $dbSettings['dev']['password'],
            'host' => $dbSettings['dev']['host'],
            'prefix' => $dbSettings['dev']['prefix'],
            'suffix' => $dbSettings['dev']['suffix']
        ],
    ],
    'version_order' => 'creation'
];
