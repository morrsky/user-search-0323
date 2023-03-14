<?php

declare(strict_types=1);

use Component\User\Presentation\Web\Actions\ListAction as ListUsers;
use Component\User\Presentation\Web\Actions\ReadAction as UserDetails;
use Component\User\Presentation\Web\Actions\CreateAction as CreateUser;
use FastRoute\RouteCollector;

$container = require __DIR__ . '/../app/bootstrap.php';

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', ListUsers::class);
    $r->addRoute(['POST','GET'], '/users/create', CreateUser::class);
    $r->addRoute('GET', '/users/{id}', UserDetails::class);
});

$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo '405 Method Not Allowed';
        break;

    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];

        $container->call($controller, $parameters);
        break;
}
