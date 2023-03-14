<?php

use App\Application\Settings\Settings;

return new Settings([
    'database' => [
        'production' => [
            'driver' => 'Pdo_Mysql', // or Pdo_Sqlite
            'name' => "app_users",
            'username' => "app_users",
            'password' => "password123",
            'host' => "localhost",
            'port' => 3306,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'suffix' => '',
            'prefix' => '',
        ],
        'dev' => [
            'driver' => 'Pdo_Sqlite', // or Pdo_Mysql
            'name' => sprintf("%s/var/data/rdbms/application.sqlite3",APP_ROOT_DIRPATH),
            'username' => null,
            'password' => null,
            'host' => null,
            'port' => null,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'suffix' => '',
        ],
    ]
]);
