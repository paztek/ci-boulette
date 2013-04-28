<?php
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\NoResultException;

Request::enableHttpMethodParameterOverride();

$repositoriesApp = $app['controllers_factory'];

$repositoriesApp->get('/', function(Request $request) use ($app) {
    $em = $app['orm.em'];

    // We find all the repositories
    $repositories = $em->getRepository('CiBoulette\Model\Repository')->findAll();

    return $app['twig']->render('repositories/list.html.twig', array('repositories' => $repositories));
});

$repositoriesApp->get('/new', function(Request $request) use ($app) {
    return $app['twig']->render('repositories/new.html.twig');
});

$repositoriesApp->post('/', function(Request $request) use ($app) {
    $em = $app['orm.em'];

    // We create a new repository based on posted values
    $repository = new \CiBoulette\Model\Repository();
    $repository->setName($request->request->get('name'));
    $repository->setUrl('https://github.com/' . $request->request->get('url'));
    $repository->setWorkingDir($request->request->get('working_dir'));
    $repository->setActive($request->request->get('active', 0));

    $em->persist($repository);
    $em->flush();

    return $app->redirect('/repositories');
});

$repositoriesApp->get('/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$id.' can\'t be found', $exception);
    }

    return $app['twig']->render('repositories/show.html.twig', array('repository' => $repository));
});

$repositoriesApp->get('/{id}/edit', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$id.' can\'t be found', $exception);
    }

    return $app['twig']->render('repositories/edit.html.twig', array('repository' => $repository));
});

$repositoriesApp->put('/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$id.' can\'t be found', $exception);
    }

    $repository->setName($request->request->get('name'));
    $repository->setUrl($request->request->get('url'));
    $repository->setWorkingDir($request->request->get('working_dir'));
    $repository->setActive($request->request->get('active', 0));

    $em->flush();

    return $app->redirect('/repositories/');
});

$repositoriesApp->delete('/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$id.' can\'t be found', $exception);
    }

    $em->remove($repository);

    $em->flush();

    return $app->redirect('/repositories/');
});

$repositoriesApp->put('/{id}/activate', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$id.' can\'t be found', $exception);
    }

    $repository->setActive(true);

    $em->flush();

    return $app->redirect('/repositories/');
});

$repositoriesApp->put('/{id}/deactivate', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$id.' can\'t be found', $exception);
    }

    $repository->setActive(false);

    $em->flush();

    return $app->redirect('/repositories/');
});

return $repositoriesApp;