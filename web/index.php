<?php

$app = require_once __DIR__.'/../bootstrap.php';

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

Request::enableHttpMethodParameterOverride();

/*
 * Routes
 */
$app->get('/', function (Request $request) use($app) {
    $em = $app['orm.em'];

    // We find the repository list
    $repositories = $em->getRepository('CiBoulette\Model\Repository')->findAll();

    return $app['twig']->render('dashboard.html.twig', array('repositories' => $repositories));
});

$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
});

$app->get('/repositories', function(Request $request) use ($app) {
    $em = $app['orm.em'];

    // We find all the repositories
    $repositories = $em->getRepository('CiBoulette\Model\Repository')->findAll();

    return $app['twig']->render('repositories/list.html.twig', array('repositories' => $repositories));
});

$app->get('/repositories/new', function(Request $request) use ($app) {
    return $app['twig']->render('repositories/new.html.twig');
});

$app->post('/repositories', function(Request $request) use ($app) {
    $em = $app['orm.em'];

    // We create a new repository based on posted values
    $repository = new \CiBoulette\Model\Repository();
    $repository->setName($request->request->get('name'));
    $repository->setUrl($request->request->get('url'));
    $repository->setActive($request->request->get('active', 0));

    $em->persist($repository);
    $em->flush();

    return $app->redirect('/repositories');
});

$app->get('/repositories/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);

    if (!$repository) throw new NotFoundHttpException('The repository with id = '.$request->query->get('id').' can\'t be found');

    return $app['twig']->render('repositories/show.html.twig', array('repository' => $repository));
});

$app->get('/repositories/{id}/edit', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);

    if (!$repository) throw new NotFoundHttpException('The repository with id = '.$request->query->get('id').' can\'t be found');

    return $app['twig']->render('repositories/edit.html.twig', array('repository' => $repository));
});

$app->put('/repositories/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);

    if (!$repository) throw new NotFoundHttpException('The repository with id = '.$id.' can\'t be found');

    $repository->setName($request->request->get('name'));
    $repository->setUrl($request->request->get('url'));
    $repository->setActive($request->request->get('active', 0));

    $em->flush();

    return $app->redirect('/repositories');
});

$app->delete('/repositories/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);

    if (!$repository) throw new NotFoundHttpException('The repository with id = '.$id.' can\'t be found');

    $em->remove($repository);

    $em->flush();

    return $app->redirect('/repositories');
});

/*
 * Debug Routes
 */
if ($app['debug']) {
	$app->get('/info', function() {
		ob_start();
		phpinfo();
		$info = ob_get_contents();
		ob_end_clean();
		return $info;
	});
}
/*
 * Error handling (404, 500, ...)
 */
$app->error(function(\Exception $exception) use ($app) {
    if ($exception instanceof NotFoundHttpException) {
        return $app['twig']->render('404.html.twig');
    }
    return $app['twig']->render('500.html.twig', array('message' => $exception->getMessage()));
});

$app->run();

return $app;