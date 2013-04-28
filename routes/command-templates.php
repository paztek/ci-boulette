<?php
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\NoResultException;

Request::enableHttpMethodParameterOverride();

$templatesApp = $app['controllers_factory'];

$templatesApp->get('/', function(Request $request) use ($app) {
    $em = $app['orm.em'];

    // We find all the command templates
    $templates = $em->getRepository('CiBoulette\Model\CommandTemplate')->findAll();

    return $app['twig']->render('command-templates/list.html.twig', array('templates' => $templates));
});

$templatesApp->get('/new', function(Request $request) use ($app) {
    return $app['twig']->render('command-templates/new.html.twig');
});

$templatesApp->post('/', function(Request $request) use ($app) {
    $em = $app['orm.em'];

    // We create a new command template based on posted values
    $template = new \CiBoulette\Model\CommandTemplate();
    $template->setName($request->request->get('name'));
    $template->setCommand($request->request->get('command'));

    $em->persist($template);
    $em->flush();

    return $app->redirect('/templates');
});

$templatesApp->get('/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the command template
    try {
        $template = $em->getRepository('CiBoulette\Model\CommandTemplate')->find($id);
    } catch (NoResultException $exception) {
        throw new NotFoundHttpException('The command template with id = '.$id.' can\'t be found', $exception);
    }

    return $app['twig']->render('command-templates/show.html.twig', array('template' => $template));
});

$templatesApp->get('/{id}/edit', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the command template
    try {
        $template = $em->getRepository('CiBoulette\Model\CommandTemplate')->find($id);
    } catch (NoResultException $exception) {
        throw new NotFoundHttpException('The command template with id = '.$id.' can\'t be found', $exception);
    }

    return $app['twig']->render('command-templates/edit.html.twig', array('template' => $template));
});

$templatesApp->put('/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the command template
    try {
        $template = $em->getRepository('CiBoulette\Model\CommandTemplate')->find($id);
    } catch (NoResultException $exception) {
        throw new NotFoundHttpException('The command template with id = '.$id.' can\'t be found', $exception);
    }

    $template->setName($request->request->get('name'));
    $template->setCommand($request->request->get('command'));

    $em->flush();

    return $app->redirect('/templates');
});

$templatesApp->delete('/{id}', function(Request $request, $id) use ($app) {
    $em = $app['orm.em'];

    // We find the command template
    try {
        $template = $em->getRepository('CiBoulette\Model\CommandTemplate')->find($id);
    } catch (NoResultException $exception) {
        throw new NotFoundHttpException('The command template with id = '.$id.' can\'t be found', $exception);
    }

    $em->remove($template);

    $em->flush();

    return $app->redirect('/templates');
});

return $templatesApp;
