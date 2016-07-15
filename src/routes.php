<?php

use Aura\Router\RouterContainer;
use Slim\Views\PhpRenderer;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

$request = ServerRequestFactory::fromGlobals(
	$_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$routerContainer = new RouterContainer();

$genarator = $routerContainer->getGenerator();
$map = $routerContainer->getMap();

$view = new PhpRenderer(__DIR__ . '/../templates/');

$entityManager = getEntityManager();

require_once __DIR__ . '/categories.php';
require_once __DIR__ . '/posts.php';

$matcher = $routerContainer->getMatcher();

$route = $matcher->match($request);

foreach ($route->attributes as $key => $value) {
	$request = $request->withAttribute($key, $value);
}

$callable = $route->handler;

/** @var Response $response */
$response = $callable($request, new Response());

if ($response instanceof Response\RedirectResponse) {
	header("location:{$response->getHeader("location")[0]}");
} elseif ($response instanceof Response) {
	echo $response->getBody();
}
