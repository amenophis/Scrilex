<?php

namespace Scrilex\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminUser implements ControllerProviderInterface {

    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];

        $controllers->match('/', function (Request $request) use ($app) {
            
            $users = $app['db.orm.em']->getRepository('Scrilex\Entity\User')->findAll();

            return $app['twig']->render('admin_user/list.html.twig', array(
                'users' => $users
            ));
        })->bind('admin_user');
        
        $controllers->match('/new', function () use ($app) {
            $form = $app['form.factory']->create(new \Scrilex\Form\Admin\UserAdd());
            
            if ('POST' == $app['request']->getMethod()) {
                $form->bind($app['request']);

                if ($form->isValid()) {
                    $user = $form->getData();
                    
                    $encoder = $app['security.encoder_factory']->getEncoder($user);
                    $password = $encoder->encodePassword('foo', $user->getSalt());
                    $user->setPassword($password);
                    
                    $app['db.orm.em']->persist($user);
                    $app['db.orm.em']->flush();
                    return '';
                }
            }
            return $app['twig']->render('user/new.html.twig', array(
                'form' => $form->createView()
            ));
        })->bind('admin_user_new');
        
        $controllers->match('/{id}/edit', function ($id) use ($app) {
            $user = $app['db.orm.em']->getRepository('Scrilex\Entity\User')->find($id);
            if(!$user) return $app->abort (404, 'Unknown user');
            
            $form = $app['form.factory']->create(new \Scrilex\Form\Admin\UserEdit(), $user);
            if ('POST' == $app['request']->getMethod()) {
                $form->bind($app['request']);
                if ($form->isValid()) {
                    $user = $form->getData();
                    
                    /*$reqUser = $app['request']->get($formType->getName());
                    if(($plainpassword = $reqUser['password_new']) && $reqUser['password_new'] == $reqUser['password_confirm'])
                    {
                        $encoder = $app['security.encoder_factory']->getEncoder($user);
                        $password = $encoder->encodePassword($plainpassword, $user->getSalt());
                        $user->setPassword($password);
                    }*/
                    
                    $app['db.orm.em']->flush();
                    return "";
                }
            }
            
            return $app['twig']->render('_form_modal.html.twig', array(
                'form' => $form->createView(),
                'form_action' => $app['url_generator']->generate('admin_user_edit', array('id' => $id))
            ));
        })->bind('admin_user_edit');
        
        $controllers->match('/{id}/delete', function ($id) use ($app) {
            $user = $app['db.orm.em']->getRepository('Scrilex\Entity\User')->find($id);
            if(!$user) return $app->abort (404, 'Unknown user');
            
            $app['db.orm.em']->remove($user);
            $app['db.orm.em']->flush();
            
            return $app->redirect($app['url_generator']->generate('admin_user'));
        })->bind('admin_user_delete');
        
        return $controllers;
    }
}