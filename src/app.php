<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;
$app['is_cli'] = function()
{
    return php_sapi_name() == 'cli';
};


require __DIR__.'/bootstrap.php';

$app->before(function () use ($app) { });

if(!$app['is_cli'])
{
    $app->mount('/', new \Scrilex\ControllerProvider\Main());
    $app->mount('/project', new \Scrilex\ControllerProvider\Project());
    $app->mount('/user', new \Scrilex\ControllerProvider\User());


    $app->before(function() use ($app) {
        ob_start();
        echo "\nvar javascript_routes = new Array();";
        foreach($app["routes"]->all() as $name => $route)
        {
            echo "\njavascript_routes['$name'] = '{$route->getPattern()}';";
        }

        $app['javascript_routes'] = ob_get_clean();
        if (isset($app['twig'])) {
            $app['twig']->addGlobal('javascript_routes', $app['javascript_routes']);
        }

        //Current user project list for use in twig
        $app['twig']->addGlobal('projects', $app['db.orm.em']->getRepository('Scrilex\Entity\Project')->findAll());
    });
}
return $app;