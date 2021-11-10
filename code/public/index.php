<?php 

use FastRoute\RouteCollector;

session_start();

$container = require __DIR__ . '/../app/bootstrap.php';


$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['FinApp\Controllers\MainController', 'index']);
    $r->addRoute('GET', '/index', ['FinApp\Controllers\MainController', 'index']);
    $r->addRoute('GET', '/login', ['FinApp\Controllers\MainController', 'getLogin']);
    $r->addRoute('POST', '/login', ['FinApp\Controllers\MainController', 'postLogin']);
    $r->addRoute('POST', '/logout', ['FinApp\Controllers\MainController', 'logout']);
    $r->addRoute('POST', '/withdraw', ['FinApp\Controllers\MainController', 'doWithdraw']);

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

        // We could do $container->get($controller) but $container->call()
        // does that automatically
        $container->call($controller, $parameters);
        break;
}
