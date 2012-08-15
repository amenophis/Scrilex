<?php

namespace Scrilex\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Scrilex\Form\User as UserForm;

class User implements ControllerProviderInterface {

    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];

        $controllers->match('/list', function (Request $request) use ($app) {
            
            $users = $app['users']->findAll();

            return $app['twig']->render('user/list.html.twig', array(
                'users' => $users
            ));
        })->bind('user_list');
        
        $controllers->match('/new', function () use ($app) {
            $form = $app['form.factory']->create(new UserForm());
            
            if ('POST' == $app['request']->getMethod()) {
                $form->bind($app['request']->get($form->getName()));

                if ($form->isValid()) {
                    $user = $form->getData();
                    if($app['users']->insert($user)){
                        return '';
                    }
                }
            }
            return $app['twig']->render('user/new.html.twig', array(
                'form' => $form->createView()
            ));
        })->bind('user_new');
        
        return $controllers;
    }
}