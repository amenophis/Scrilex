<?php

require_once __DIR__ . '/../vendor/autoload.php';

global $app;

$app = new Silex\Application();
$app['debug'] = true;
$app['is_cli'] = function()
{
    return php_sapi_name() == 'cli';
};

require __DIR__.'/bootstrap.php';

$app->before(function () use ($app) {
    $app['base_url'] = $app['request']->getScheme().'://'.$app['request']->getHttpHost().$app['request']->getBaseUrl();
});

if(!$app['is_cli'])
{
    $app->mount('/api/projects', new \Scrilex\ControllerProvider\API\Project('Scrilex\\Entity\\Project'));
    
    $app->mount('/', new \Scrilex\ControllerProvider\Main());
    $app->mount('/project', new \Scrilex\ControllerProvider\Project());

    $app->mount('/admin/user', new Scrilex\ControllerProvider\Admin\User());
    
    $app->before(function() use ($app) {
        $app['javascript_routes'] = "";
        $app['javascript_routes'] .= "\nvar javascript_routes = new Array();";
        foreach($app["routes"]->all() as $name => $route)
        {
            $app['javascript_routes'] .= "\njavascript_routes['$name'] = '{$route->getPattern()}';";
        }
        
        if (isset($app['twig'])) {
            $app['twig']->addGlobal('javascript_routes', $app['javascript_routes']);
        }

        //Current user project list for use in twig
        $app['twig']->addGlobal('projects', $app['db.orm.em']->getRepository('Scrilex\Entity\Project')->findAll());
    });
}
return $app;