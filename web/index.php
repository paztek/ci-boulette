<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Parser;

$app = new Silex\Application();

$app['debug'] = true;

// The Logging Service
$app->register(new Silex\Provider\MonologServiceProvider(), array
(
	'monolog.logfile' => __DIR__.'/../logs/silex.log',
));

$yaml = new Parser();

$userConfig = $yaml->parse(file_get_contents(__DIR__.'/../users.yml'));

$users = array();

foreach ($userConfig as $username => $infos)
{
    $users[$username] = array($infos['role'], $infos['password']);
}

// Doctrine DBAL Service provider
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
        'db.options' => array(
                'driver'   => 'pdo_sqlite',
                'path'     => __DIR__.'/../data/app.db',
        ),
));

// Doctrine ORM Service provider
$app->register(new Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider(), array(
        "orm.proxies_dir" => "/path/to/proxies",
        "orm.em.options" => array(
                "mappings" => array(
                        array(
                                "type" => "annotation",
                                "namespace" => "CiBoulette\Model",
                                "resources_namespace" => "CiBoulette\Model",
                        ),
                ),
        ),
));

// The Session service
$app->register(new Silex\Provider\SessionServiceProvider());

// The Security service
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
        'security.firewalls' => array(
                'login' => array(
                        'pattern' => '/login$'),
                'main' => array(
                        'pattern' => '^/',
                        'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
                        'logout' => array('logout_path' => '/logout'),
                        'users' => $users
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
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
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
