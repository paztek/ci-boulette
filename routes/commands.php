<?php
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\NoResultException;

Request::enableHttpMethodParameterOverride();

$commandsApp = $app['controllers_factory'];

$commandsApp->get('/', function(Request $request, $repositoryId) use ($app) {
    $em = $app['orm.em'];

    // We find the repository with the associated commands
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->findWithCommands($repositoryId);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$repositoryId.' can\'t be found', $exception);
    }

    return $app['twig']->render('commands/list.html.twig', array('repository' => $repository));
});

$commandsApp->get('/new', function(Request $request, $repositoryId) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($repositoryId);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$repositoryId.' can\'t be found', $exception);
    }

    return $app['twig']->render('commands/new.html.twig', array('repository' => $repository));
});

$commandsApp->post('/', function(Request $request, $repositoryId) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($repositoryId);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$repositoryId.' can\'t be found', $exception);
    }

    // We find the last position for the associated commands
    $lastPosition = $em->getRepository('CiBoulette\Model\Command')->findLastPositionForRepository($repository);

    // We create a new command based on posted values
    $command = new \CiBoulette\Model\Command();
    $command->setRepository($repository);
    $command->setName($request->request->get('name'));
    $command->setCommand($request->request->get('command'));
    $command->setActive($request->request->get('active', 0));
    $command->setPosition($lastPosition + 1);

    $em->persist($command);
    $em->flush();

    return $app->redirect('/repositories/'.$repositoryId.'/commands');
});

$commandsApp->get('/{id}', function(Request $request, $repositoryId, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($repositoryId);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$repositoryId.' can\'t be found', $exception);
    }

    // We find the command
    try
    {
        $command = $em->getRepository('CiBoulette\Model\Command')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The command with id = '.$id.' can\'t be found', $exception);
    }

    return $app['twig']->render('commands/show.html.twig', array('repository' => $repository, 'command' => $command));
});

$commandsApp->get('/{id}/edit', function(Request $request, $repositoryId, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($repositoryId);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$repositoryId.' can\'t be found', $exception);
    }

    // We find the command
    try
    {
        $command = $em->getRepository('CiBoulette\Model\Command')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The command with id = '.$id.' can\'t be found', $exception);
    }

    return $app['twig']->render('commands/edit.html.twig', array('repository' => $repository, 'command' => $command));
});

$commandsApp->put('/{id}', function(Request $request, $repositoryId, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($repositoryId);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$repositoryId.' can\'t be found', $exception);
    }

    // We find the command
    try
    {
        $command = $em->getRepository('CiBoulette\Model\Command')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The command with id = '.$id.' can\'t be found', $exception);
    }

    $command->setName($request->request->get('name'));
    $command->setCommand($request->request->get('command'));
    $command->setActive($request->request->get('active', 0));

    $em->flush();

    return $app->redirect('/repositories/'.$repositoryId.'/commands');
});

$commandsApp->delete('/{id}', function(Request $request, $repositoryId, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($repositoryId);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$repositoryId.' can\'t be found', $exception);
    }

    // We find the command
    try
    {
        $command = $em->getRepository('CiBoulette\Model\Command')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The command with id = '.$id.' can\'t be found', $exception);
    }

    $em->remove($command);

    $em->flush();

    return $app->redirect('/repositories/'.$repositoryId.'/commands');
});

$commandsApp->put('/{id}/activate', function(Request $request, $repositoryId, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($repositoryId);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$repositoryId.' can\'t be found', $exception);
    }

    // We find the command
    try
    {
        $command = $em->getRepository('CiBoulette\Model\Command')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The command with id = '.$id.' can\'t be found', $exception);
    }

    $command->setActive(true);

    $em->flush();

    return $app->redirect('/repositories/'.$repositoryId.'/commands');
});

$commandsApp->put('/{id}/deactivate', function(Request $request, $repositoryId, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the repository
    try
    {
        $repository = $em->getRepository('CiBoulette\Model\Repository')->find($repositoryId);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The repository with id = '.$repositoryId.' can\'t be found', $exception);
    }

    // We find the command
    try
    {
        $command = $em->getRepository('CiBoulette\Model\Command')->find($id);
    }
    catch (NoResultException $exception)
    {
        throw new NotFoundHttpException('The command with id = '.$id.' can\'t be found', $exception);
    }

    $command->setActive(false);

    $em->flush();

    return $app->redirect('/repositories/'.$repositoryId.'/commands');
});

return $commandsApp;
