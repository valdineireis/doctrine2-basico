<?php

use App\Entity\Post;
use App\Entity\Category;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

$map->get('posts.list', '/posts', function($request, $response) use ($view, $entityManager) {
	$repository = $entityManager->getRepository(Post::class);
	$posts = $repository->findAll();

	return $view->render($response, 'posts/list.phtml', [
		'posts' => $posts
	]);
});

$map->get('posts.create', '/posts/create', function($request, $response) use ($view) {
	return $view->render($response, 'posts/create.phtml');
});

$map->post('posts.store', '/posts/store', 
	function(ServerRequestInterface $request, $response) use ($view, $entityManager, $genarator) {
		$data = $request->getParsedBody();
		$post = new Post();
		$post->setTitulo($data['titulo'])
			->setConteudo($data['conteudo']);

		$entityManager->persist($post);
		$entityManager->flush();

		$uri = $genarator->generate('posts.list');
		return new Response\RedirectResponse($uri);
	}
);

$map->get('posts.edit', '/posts/{id}/edit', 
	function(ServerRequestInterface $request, $response) use ($view, $entityManager) {
		$id = $request->getAttribute('id');
		$repository = $entityManager->getRepository(Post::class);
		$post = $repository->find($id);
		return $view->render($response, 'posts/edit.phtml', [
			'post' => $post
		]);
});

$map->post('posts.update', '/posts/{id}/update', 
	function(ServerRequestInterface $request, $response) use ($view, $entityManager, $genarator) {
		$id = $request->getAttribute('id');
		$repository = $entityManager->getRepository(Post::class);
		$post = $repository->find($id);

		$data = $request->getParsedBody();

		$post->setTitulo($data['titulo'])
			->setConteudo($data['conteudo']);
		$entityManager->flush();

		$uri = $genarator->generate('posts.list');
		return new Response\RedirectResponse($uri);
	}
);

$map->get('posts.remove', '/posts/{id}/remove', 
	function(ServerRequestInterface $request, $response) use ($view, $entityManager, $genarator) {
		$id = $request->getAttribute('id');
		$repository = $entityManager->getRepository(Post::class);
		$post = $repository->find($id);

		$entityManager->remove($post);
		$entityManager->flush();

		$uri = $genarator->generate('posts.list');
		return new Response\RedirectResponse($uri);
	}
);

$map->get('posts.categories', '/posts/{id}/categories', 
	function(ServerRequestInterface $request, $response) use ($view, $entityManager, $genarator) {
		$id = $request->getAttribute('id');

		$repository = $entityManager->getRepository(Post::class);
		$categoryRepository = $entityManager->getRepository(Category::class);

		$categories = $categoryRepository->findAll();
		$post = $repository->find($id);

		return $view->render($response, 'posts/categories.phtml', [
			'post' => $post,
			'categories' => $categories
		]);
	}
);

$map->post('posts.set-categories', '/posts/{id}/set-categories', 
	function(ServerRequestInterface $request, $response) use ($view, $entityManager, $genarator) {
		$id = $request->getAttribute('id');
		$repository = $entityManager->getRepository(Post::class);
		$post = $repository->find($id);

		$data = $request->getParsedBody();

		/*$post->setTitulo($data['titulo'])
			->setConteudo($data['conteudo']);
		$entityManager->flush();

		$uri = $genarator->generate('posts.list');*/
		return new Response\RedirectResponse($uri);
	}
);
