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
    'root' => __DIR__.'/..'
)));

$app->register(new DoctrineServiceProvider(), $app['DoctrineServiceProvider']);
$app->register(new Amenophis\ServiceProvider\DoctrineORMServiceProvider(), $app['DoctrineORMServiceProvider']);
$app->register(new Silex\Provider\MonologServiceProvider(), $app['MonologServiceProvider']);

if(!$app['is_cli']){
    $app->register(new SessionServiceProvider());
    $app->register(new SecurityServiceProvider());
    $app->register(new UrlGeneratorServiceProvider());
    $app->register(new TwigServiceProvider(), $app['TwigServiceProvider']);
    
    $app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
        $twig->addExtension(new Scrilex\EvalExtension());

        return $twig;
    }));
    
    //$app['twig']->addExtension(new Scrilex\Eval_Extension());
    
    $app->register(new FormServiceProvider());
    $app->register(new ValidatorServiceProvider());
    $app->register(new TranslationServiceProvider(), $app['TranslationServiceProvider']);
    
    $app->register(new Silex\Provider\SecurityServiceProvider());
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
}