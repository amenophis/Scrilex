<?php

namespace Scrilex\ControllerProvider\API;

use Silex\Application;

class Task extends \Scrilex\ControllerProvider\API\Base {
    public function __construct($entityClass, $routePrefix = "tasks")
    {
        parent::__construct($entityClass, $routePrefix);
    }
    
    protected function createFromJSON($json)
    {
        $item = new \Scrilex\Entity\Task();
        return $item->setCol($json['col'])
            ->setContent($json['content'])
            ->setPos($json['pos'])
            ->setProject($json['project'])
            ->setSeverity($json['severity']);
    }
    
    protected function updateFromJSON($item, $json)
    {
        return $item->setCol($json['col'])
            ->setContent($json['content'])
            ->setPos($json['pos'])
            ->setProject($json['project'])
            ->setSeverity($json['severity']);
    }
}