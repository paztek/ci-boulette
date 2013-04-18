<?php
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

Request::enableHttpMethodParameterOverride();

$repositories = $app['controllers_factory'];
 
$repositories->get('/', function(Request $request) use ($app) {
    $em = $app['orm.em'];

    // We find all the repositories
    $repositories = $em->getRepository('CiBoulette\Model\Repository')->findAll();

    return $app['twig']->render('repositories/list.html.twig', array('repositories' => $repositories));
});

$repositories->get('/new', function(Request $request) use ($app) {
    return $app['twig']->render('repositories/new.html.twig');
});

$repositories->post('/', function(Request $request) use ($app) {
    $em = $app['orm.em'];

    // We create a new repository based on posted values
    $repository = new \CiBoulette\Model\Repository();
    $repository->setName($request->request->get('name'));
    $repository->setUrl($request->request->get('url'));
    $repository->setActive($request->request->get('active', 0));

    $em->persist($repository);
    $em->flush();

    return $app->redirect('/repositories/');
});

$repositories->get('/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);

    if (!$repository) throw new NotFoundHttpException('The repository with id = '.$request->query->get('id').' can\'t be found');

    return $app['twig']->render('repositories/show.html.twig', array('repository' => $repository));
});

$repositories->get('/{id}/edit', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);

    if (!$repository) throw new NotFoundHttpException('The repository with id = '.$request->query->get('id').' can\'t be found');

    return $app['twig']->render('repositories/edit.html.twig', array('repository' => $repository));
});

$repositories->put('/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);

    if (!$repository) throw new NotFoundHttpException('The repository with id = '.$id.' can\'t be found');

    $repository->setName($request->request->get('name'));
    $repository->setUrl($request->request->get('url'));
    $repository->setActive($request->request->get('active', 0));

    $em->flush();

    return $app->redirect('/repositories/');
});

$repositories->delete('/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);

    if (!$repository) throw new NotFoundHttpException('The repository with id = '.$id.' can\'t be found');

    $em->remove($repository);

    $em->flush();

    return $app->redirect('/repositories/');
});

$repositories->put('/{id}/activate', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);

    if (!$repository) throw new NotFoundHttpException('The repository with id = '.$id.' can\'t be found');

    $repository->setActive(true);

    $em->flush();

    return $app->redirect('/repositories/');
});

$repositories->put('/{id}/deactivate', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);

    if (!$repository) throw new NotFoundHttpException('The repository with id = '.$id.' can\'t be found');

    $repository->setActive(false);

    $em->flush();

    return $app->redirect('/repositories/');
});

return $repositories;