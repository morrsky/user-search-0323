<?php

$container = require __DIR__ . '/../app/bootstrap.php';

use Component\User\Presentation\Console\ListCommand as ListUsers;
use Component\User\Presentation\Console\DetailsCommand as UserDetails;
use Component\User\Presentation\Console\CreateCommand as CreateUser;


$app = new Silly\Application();

// use PHP-DI for dependency injection
$app->useContainer($container, $injectWithTypeHint = true);

// Display users list
$app->command('users:list', ListUsers::class);
// Display particullar user details
$app->command('users:show [id]', UserDetails::class);
// Create user
$app->command('users:create [name]', CreateUser::class);

$app->run();
