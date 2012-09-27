<?php

namespace Scrilex\ControllerProvider;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Scrilex\Form\Project as ProjectForm;
use Scrilex\Form\Task as TaskForm;

class Project implements ControllerProviderInterface {

    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
        
        $controllers->match('/new', function () use ($app) {
            $form = $app['form.factory']->create(new ProjectForm());
            
            if ('POST' == $app['request']->getMethod()) {
                $form->bind($app['request']->get($form->getName()));

                if ($form->isValid()) {
                    $project = $form->getData();
                    $app['db.orm.em']->persist($project);
                    $app['db.orm.em']->flush();
                    $url = $app['url_generator']->generate('project_show', array('id' => $project->getId()));
                    return $app->redirect($url);
                }
            }
            return $app['twig']->render('project/new.html.twig', array(
                'form' => $form->createView()
            ));
        })
        ->bind('project_new');
        
        $controllers->match('/{project_id}/task/new', function ($project_id) use ($app) {
            $form = $app['form.factory']->create(new TaskForm());
            
            if ('POST' == $app['request']->getMethod()) {
                $form->bind($app['request']->get($form->getName()));

                if ($form->isValid()) {
                    $task = $form->getData();
                    
                    $project = $app['db.orm.em']->getRepository('Scrilex\Entity\Project')->find($project_id);
                    $task->setProject($project);
                    $app['db.orm.em']->persist($project);
                    $app['db.orm.em']->flush();
                    $url = $app['url_generator']->generate('project_show', array('id' => $id));
                    return "";
                }
            }
            return $app['twig']->render('project/new_task.html.twig', array(
                'form' => $form->createView(),
                'project_id' => $project_id
            ));
        })
        ->bind('project_task_new');
        
        $controllers->match('/show/{id}', function ($id) use ($app) {
            $project  = $app['db.orm.em']->getRepository('Scrilex\Entity\Project')->find($id);
            if(!$project) $app->abort('404', 'No project for this ID');
            return $app['twig']->render('project/show.html.twig', array(
                'project' => $project
            ));
        })
        ->bind('project_show');
        
        $controllers->post('/updateTasksPositions/{id}', function ($id) use ($app) {
            $project  = $app['projects']->find($id);
            
            $results = $app['request']->get('results');
                    
            $app['db']->beginTransaction();
            try {
                for($i = 0; $i < count($results); $i++)
                {
                    $task_ids = explode('|', $results[$i]);
                    for($j = 0; $j < count($task_ids); $j++)
                    {
                        $task_id = $task_ids[$j];
                        $app['tasks']->update(array('col' => $i, 'pos' => $j), array('id' => $task_id));
                    }
                } 
                $app['db']->commit();
            } catch(Exception $e) {
                $app['db']->rollback();
            }
            
            $viewParams = array(
                'project' => $project
            );
            
            if($task_id = $app['request']->get('task_id')) {
                $viewParams['task'] = $app['tasks']->find($task_id);
            }
            
            return $app['twig']->render('project/_content.html.twig', $viewParams);
        })
        ->bind('project_updateTasksPositions');
        
        $controllers->get('/setTaskColumn/{id}/{col}', function ($id, $col) use ($app) {
            try {
                $app['tasks']->update(array('col' => $col), array('id' => $id));
            } catch(Exception $e) {
            }
            
            $task = $app['tasks']->find($id);
            $project = $app['projects']->find($task->getProjectId());
            
            return $app['twig']->render('project/_content.html.twig', array(
                'project' => $project
            ));
            
        })
        ->bind('project_setTaskColumn');
        
        $controllers->get('/task/{id}/form', function ($id) use ($app) {
            $task = $app['tasks']->find($id);
            $user = $app['users']->find($task->getUserId());
            $project = $app['projects']->find($task->getProjectId());
            
            return $app['twig']->render('project/_content.html.twig', array(
                'project' => $project,
                'task' => $task,
                'user' => $user
            ));
            
        })
        ->bind('project_taskInformations');
        
        $controllers->get('/task/{id}/{property}/{value}', function ($id, $property, $value) use ($app) {
            $app['tasks']->update(array($property => $value), array('id' => $id));
            
            $task = $app['tasks']->find($id);
            $user = $app['users']->find($task->getUserId());
            $project = $app['projects']->find($task->getProjectId());
            
            return $app['twig']->render('project/_content.html.twig', array(
                'project' => $project,
                'task' => $task,
                'user' => $user
            ));
            
        })
        ->bind('project_taskUpdateProperty');
        
        return $controllers;
    }
}