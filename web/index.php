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

/*
 * Repositories
 */
$app->mount('/repositories', include __DIR__.'/../routes/repositories.php');

/*
 * Commands
 */
$app->mount('/repositories/{repositoryId}/commands', include __DIR__.'/../routes/commands.php');

/*
 * Webhook
 */
$app->mount('/', include __DIR__.'/../routes/webhook.php');

/*
 * Pushes
 */
$app->mount ('/pushes', include __DIR__.'/../routes/pushes.php');

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
        return $app['twig']->render('404.html.twig', array('message' => $exception->getMessage()));
    }
    return $app['twig']->render('500.html.twig', array('message' => $exception->getMessage()));
});

$app->run();

return $app;