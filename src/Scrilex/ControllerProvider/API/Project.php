<?php

namespace Scrilex\ControllerProvider\API;

use Silex\Application;

class Project extends \Scrilex\ControllerProvider\API\Base {
    public function __construct($entityClass, $routePrefix = "projects")
    {
        parent::__construct($entityClass, $routePrefix);
    }
    
    protected function createFromJSON($json)
    {
        $item = new \Scrilex\Entity\Project();
        return $item->setName($json['name']);
    }
    
    protected function updateFromJSON($item, $json)
    {
        return $item->setName($json['name']);
    }
}