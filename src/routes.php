<?php

use Aura\Router\RouterContainer;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Slim\Views\PhpRenderer;
use App\Entity\Category;
use Psr\Http\Message\ServerRequestInterface;

$request = ServerRequestFactory::fromGlobals(
	$_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$routerContainer = new RouterContainer();

$genarator = $routerContainer->getGenerator();
$map = $routerContainer->getMap();

$view = new PhpRenderer(__DIR__ . '/../templates/');

$entityManager = getEntityManager();

$map->get('home', '/', function($request, $response) use ($view) {
	return $view->render($response, 'home.phtml', [
		'test' => 'Slim PHP View funcionando!!!'
	]);
});

$map->get('categories.list', '/categories', function($request, $response) use ($view, $entityManager) {
	$repository = $entityManager->getRepository(Category::class);
	$categories = $repository->findAll();

	return $view->render($response, 'categories/list.phtml', [
		'categories' => $categories
	]);
});

$map->get('categories.create', '/categories/create', function($request, $response) use ($view) {
	return $view->render($response, 'categories/create.phtml');
});

$map->post('categories.store', '/categories/store', 
	function(ServerRequestInterface $request, $response) use ($view, $entityManager, $genarator) {
		$data = $request->getParsedBody();
		$category = new Category();
		$category->setNome($data['nome']);

		$entityManager->persist($category);
		$entityManager->flush();

		$uri = $genarator->generate('categories.list');
		return new Response\RedirectResponse($uri);
	}
);

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
