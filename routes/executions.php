<?php
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\NoResultException;

Request::enableHttpMethodParameterOverride();

$executionsApp = $app['controllers_factory'];

$executionsApp->get('/', function(Request $request, $pushId) use ($app) {
    $em = $app['orm.em'];

    // We find the push with the associated executions
    try
    {
        $push = $em->getRepository('CiBoulette\Model\Push')->findWithExecutions($pushId);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The push with id = '.$pushId.' can\'t be found', $exception);
    }

    return $app['twig']->render('executions/list.html.twig', array('push' => $push));
});

$executionsApp->get('/{id}', function(Request $request, $pushId, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $push = $em->getRepository('CiBoulette\Model\Push')->find($pushId);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The push with id = '.$pushId.' can\'t be found', $exception);
    }

    // We find the execution
    try
    {
        $execution = $em->getRepository('CiBoulette\Model\Execution')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The execution with id = '.$id.' can\'t be found', $exception);
    }

    return $app['twig']->render('executions/show.html.twig', array('push' => $push, 'execution' => $execution));
});

return $executionsApp;
