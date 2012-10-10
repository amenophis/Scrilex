<?php

namespace Scrilex\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\SerializerBundle\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="Scrilex\Entity\TaskHistoryRepository")
 * @ORM\Table(name="task_history")
 */
class TaskHistory {
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="histories")
     */
    protected $task;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="histories")
     */
    protected $user;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;
    
    public function getId() { return $this->id; }
    public function getCreatedAt() { return $this->created_at; }
    public function getTask() { return $this->task; }
    
    public function setId($id) { $this->id = $id; return $this; }
    public function setTask($task) { $this->task = $task; return $this; }
    
    /** @PrePersist */
    public function doStuffOnPrePersist()
    {
        $this->created_at = date('Y-m-d H:m:s');
    }
    
}