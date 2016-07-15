<?php

use App\Entity\Category;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

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

$map->get('categories.edit', '/categories/{id}/edit', 
	function(ServerRequestInterface $request, $response) use ($view, $entityManager) {
		$id = $request->getAttribute('id');
		$repository = $entityManager->getRepository(Category::class);
		$category = $repository->find($id);
		return $view->render($response, 'categories/edit.phtml', [
			'category' => $category
		]);
});

$map->post('categories.update', '/categories/{id}/update', 
	function(ServerRequestInterface $request, $response) use ($view, $entityManager, $genarator) {
		$id = $request->getAttribute('id');
		$repository = $entityManager->getRepository(Category::class);
		$category = $repository->find($id);

		$data = $request->getParsedBody();

		$category->setNome($data['nome']);
		$entityManager->flush();

		$uri = $genarator->generate('categories.list');
		return new Response\RedirectResponse($uri);
	}
);

$map->get('categories.remove', '/categories/{id}/remove', 
	function(ServerRequestInterface $request, $response) use ($view, $entityManager, $genarator) {
		$id = $request->getAttribute('id');
		$repository = $entityManager->getRepository(Category::class);
		$category = $repository->find($id);

		$entityManager->remove($category);
		$entityManager->flush();

		$uri = $genarator->generate('categories.list');
		return new Response\RedirectResponse($uri);
	}
);
