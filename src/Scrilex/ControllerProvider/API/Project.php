<?php

namespace Scrilex\ControllerProvider\API;

use Silex\Application;

class Project extends \Scrilex\ControllerProvider\API\Base {
    public function __construct($entityClass, $routePrefix = "projects")
    {
        parent::__construct($entityClass, $routePrefix);
    }
}