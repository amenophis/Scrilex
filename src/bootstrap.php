<?php

use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\TranslationServiceProvider;

use Knp\Provider\RepositoryServiceProvider;
//use Knp\Provider\MigrationServiceProvider;

$app->register(new DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'scrilex',
        'user'      => 'root',
        'password'  => 'root',
    ),
));

$app->register(new Amenophis\ServiceProvider\DoctrineORMServiceProvider(), array(
    'db.orm.entities' => array(
        array(
            'type' => 'annotation',
            'path' => __DIR__.'/Scrilex/Entity',
            'namespace' => 'Scrilex\Entity'
        )
    )
));

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/development.log',
));

if(!$app['is_cli']){
    $app->register(new SessionServiceProvider());
    $app->register(new SecurityServiceProvider());
    $app->register(new UrlGeneratorServiceProvider());
    $app->register(new TwigServiceProvider(), array(
        'twig.path' => array(__DIR__.'/Resources/views'),
        'twig.form.templates' => array('form_div_layout_bootstrap.html.twig')
    ));
    $app->register(new FormServiceProvider());
    $app->register(new ValidatorServiceProvider());
    $app->register(new TranslationServiceProvider(), array(
        'translator.messages' => array(),
    ));
    
    //$app['migration.register_before_handler'] = true;
    //$app->register(new \Knp\Provider\MigrationServiceProvider(), array(
    //    'migration.path' => __DIR__.'/Resources/migrations'
    //));
    
    $app['security.firewalls'] = array(
        'login' => array(
            'pattern' => '^/login$',
        ),
        'secured' => array(
            'pattern' => '^.*$',
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'logout' => array('logout_path' => '/logout'),
            'users' => $app->share(function () use ($app) {
                return $app['db.orm.em']->getRepository('Scrilex\Entity\User');
            })
        )
    );

    $app['security.access_rules'] = array(
        array('^.*$', 'ROLE_USER')
    );        

    $app['security.role_hierarchy'] = array(
        'ROLE_ADMIN' => array('ROLE_MANAGER'),
        'ROLE_MANAGER' => array('ROLE_USER'),
        'ROLE_USER' => array()
    );
}