<?php

namespace Scrilex\ControllerProvider\API;

use Silex\Application;

class Task extends \Scrilex\ControllerProvider\API\Base {
    public function __construct($entityClass, $routePrefix = "tasks")
    {
        parent::__construct($entityClass, $routePrefix);
    }
}