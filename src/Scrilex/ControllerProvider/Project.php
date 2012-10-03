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
                    $task->setPos(1000);
                    $task->setCol(0);
                    $task->setSeverity(0);
                    $app['db.orm.em']->persist($task);
                    $app['db.orm.em']->flush();
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
            $project  = $app['db.orm.em']->getRepository('Scrilex\Entity\Project')->find($id);
            
            $results = $app['request']->get('results');
                    
            for($i = 0; $i < count($results); $i++)
            {
                if($results[$i]){
                    $task_ids = explode('|', $results[$i]);
                    for($j = 0; $j < count($task_ids); $j++)
                    {
                        $task = $app['db.orm.em']->getRepository('Scrilex\Entity\Task')->find($task_ids[$j]);
                        if($task)
                        {
                            $task->setCol($i);
                            $task->setPos($j);
                        }
                    }
                }
            }
            $app['db.orm.em']->flush();
            $viewParams = array(
                'project' => $project
            );
            
            if($task_id = $app['request']->get('task_id')) {
                $viewParams['task'] = $app['db.orm.em']->getRepository('Scrilex\Entity\Task')->find($task_id);
            }
            
            return $app['twig']->render('project/_content.html.twig', $viewParams);
        })
        ->bind('project_updateTasksPositions');
        
        $controllers->get('/setTaskColumn/{id}/{col}', function ($id, $col) use ($app) {
            $task = $app['db.orm.em']->getRepository('Scrilex\Entity\Task')->find($id);
            $task->setCol($col);
            $app['db.orm.em']->flush();
            
            return $app['twig']->render('project/_content.html.twig', array(
                'project' => $task->getProject()
            ));
            
        })
        ->bind('project_setTaskColumn');
        
        $controllers->get('/task/{id}/form', function ($id) use ($app) {
            $task = $app['db.orm.em']->getRepository('Scrilex\Entity\Task')->find($id);
           return $app['twig']->render('project/_content.html.twig', array(
               'project' => $task->getProject(), 
               'task' => $task
            ));
            
        })
        ->bind('project_taskInformations');
        
        $controllers->get('/task/{id}/{property}/{value}', function ($id, $property, $value) use ($app) {
            
            $method = "set".ucfirst($property);
            
            $task = $app['db.orm.em']->getRepository('Scrilex\Entity\Task')->find($id);
            $task->$method($value);
            $app['db.orm.em']->flush();
            
            return $app['twig']->render('project/_content.html.twig', array(
                'project' => $task->getProject(),
                'task' => $task,
            ));
            
        })
        ->bind('project_taskUpdateProperty');
        
        return $controllers;
    }
}