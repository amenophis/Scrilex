<?php

namespace Scrilex\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Main implements ControllerProviderInterface {

    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];

        $controllers->match('/', function (Request $request) use ($app) {
            /*$p = new \Scrilex\Entity\Project();
            $p->setName('Entity');
            
            $app['db.orm.em']->persist($p);
            $app['db.orm.em']->flush();*/
            
            //$em = $app['db.orm.em'];
            //$entity = $em->getRepository('Scrilex\Entity\Project')->findOneBy(array('id' => 1));
            
            return $app['twig']->render('homepage.html.twig');
        })->bind('homepage');
        
        $controllers->get('/login', function(Request $request) use ($app) {
            return $app['twig']->render('login.html.twig', array(
                'error'         => $app['security.last_error']($request),
                'last_username' => $app['session']->get('_security.last_username'),
                //'user'          => \Scrilex\Repository\User::getUser($app)
            ));
        });
        
        $controllers->get('/backbone', function(Request $request) use ($app) {
            return $app['twig']->render('backbone.html.twig');
        });
        
        return $controllers;
    }
}