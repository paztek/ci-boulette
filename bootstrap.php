<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

// Parse users.yml
$yaml = new Symfony\Component\Yaml\Parser();
$userConfig = $yaml->parse(file_get_contents(__DIR__.'/data/users.yml'));
$users = array();
foreach ($userConfig as $username => $infos)
{
    $users[$username] = array($infos['role'], $infos['password']);
}

// The Security service
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
        'security.firewalls' => array(
                'login' => array(
                        'pattern' => '/login$'),
				'webhook' => array(
						'pattern' => '/webhook$'),
                'main' => array(
                        'pattern' => '^/',
                        'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
                        'logout' => array('logout_path' => '/logout'),
                        'users' => $users
                        )
                )
        )
);

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

// The Logging Service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
	'monolog.logfile' => __DIR__.'/logs/silex.log',
));

// The Twig service
$app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/views'
        )
);

return $app;