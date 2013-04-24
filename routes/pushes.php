<?php
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\NoResultException;

Request::enableHttpMethodParameterOverride();

$pushesApp = $app['controllers_factory'];

$pushesApp->get('/', function(Request $request) use ($app) {
    $em = $app['orm.em'];

    // We find all the pushes
    $pushes = $em->getRepository('CiBoulette\Model\Push')->findAllOrdered();

    return $app['twig']->render('pushes/list.html.twig', array('pushes' => $pushes));
});

$pushesApp->get('/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the push
    try
    {
        $push = $em->getRepository('CiBoulette\Model\Push')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The push with id = '.$id.' can\'t be found', $exception);
    }

    return $app['twig']->render('pushes/show.html.twig', array('push' => $push));
});


$pushesApp->delete('/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the push
    try
    {
        $push = $em->getRepository('CiBoulette\Model\Push')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The push with id = '.$id.' can\'t be found', $exception);
    }

    $em->remove($push);

    $em->flush();

    return $app->redirect('/pushes/');
});

return $pushesApp;