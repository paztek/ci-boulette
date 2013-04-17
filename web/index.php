<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

// The Logging Service
$app->register(new Silex\Provider\MonologServiceProvider(), array
(
	'monolog.logfile' => __DIR__.'/../logs/silex.log',
));

// The Security service
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
        'security.firewalls' => array(
                'login' => array(
                        'pattern' => '/login$'),
                'main' => array(
                        'pattern' => '^/',
                        'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
                        'logout' => array('logout_path' => '/logout')
                        )
                )
        )
);

// The Twig service
$app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
        )
);

/*
 * Routes
 */
$app->get('/', function (Request $request) use($app) {
    // TODO Display dashboard
});

$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig');
});

$app->post('/login_check', function(Request $request) use ($app) {
    // TODO Handle login form and log user in
});

$app->get('/logout', function(Request $request) use ($app) {
    // TODO Log user out and redirect to /
});

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
