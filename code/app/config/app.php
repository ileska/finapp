<?php

use FinApp\Components\Database;
use FinApp\Components\Router;
use FinApp\Components\View;
use FinApp\Components\AuthManager;
use FinApp\Models\User;

use function DI\create;


return [
	'Database' => Database::getInstance(),
	'auth' => create(AuthManager::class)->constructor(DI\get('Database')),
	User::class => create(User::class)->constructor(DI\get('auth'), DI\get('Database')),
	Router::class => create(Router::class),
];