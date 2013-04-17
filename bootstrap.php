<?php

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Yaml\Parser;

$app = new Silex\Application();

$app['debug'] = true;

// The Logging Service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
	'monolog.logfile' => __DIR__.'/logs/silex.log',
));

$yaml = new Parser();

$userConfig = $yaml->parse(file_get_contents(__DIR__.'/users.yml'));

$users = array();

foreach ($userConfig as $username => $infos)
{
    $users[$username] = array($infos['role'], $infos['password']);
}

// Doctrine DBAL Service provider
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
        'db.options' => array(
                'driver'   => 'pdo_sqlite',
                'path'     => __DIR__.'/data/app.db',
        ),
));

// Doctrine ORM Service provider
$app->register(new Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider(), array(
        "orm.proxies_dir" => __DIR__.'/cache/proxies',
        "orm.em.options" => array(
                "mappings" => array(
                        array(
                                "type" => "annotation",
                                "namespace" => "CiBoulette\Model",
                                "path" => __DIR__."/src/CiBoulette/Model",
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
        'twig.path' => __DIR__.'/views'
        )
);

return $app;