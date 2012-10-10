<?php

use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\TranslationServiceProvider;

$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__."/../config/dev.yml", array(
    '__DIR__' => __DIR__
)));

$app->register(new JMS\SerializerServiceProvider\SerializerServiceProvider(), array(
    'serializer.src_directory' => __DIR__."/../vendor/jms/serializer-bundle/src",
    'serializer.cache.directory' => __DIR__."/../cache/serializer"
));

$app->register(new DoctrineServiceProvider(), $app['DoctrineServiceProvider']);

$app->register(new Amenophis\ServiceProvider\DoctrineORMServiceProvider(), $app['DoctrineORMServiceProvider']);

$app->register(new Silex\Provider\MonologServiceProvider(), $app['MonologServiceProvider']);

if(!$app['is_cli']){
    $app->register(new SessionServiceProvider());
    $app->register(new SecurityServiceProvider());
    $app->register(new UrlGeneratorServiceProvider());
    $app->register(new TwigServiceProvider(), $app['TwigServiceProvider']);
    $app->register(new FormServiceProvider());
    $app->register(new ValidatorServiceProvider());
    $app->register(new TranslationServiceProvider(), $app['TranslationServiceProvider']);
    
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

    //$app['security.role_hierarchy'] = array(
    //    'ROLE_ADMIN' => array('ROLE_MANAGER'),
    //    'ROLE_MANAGER' => array('ROLE_USER'),
    //    'ROLE_USER' => array()
    //);
}