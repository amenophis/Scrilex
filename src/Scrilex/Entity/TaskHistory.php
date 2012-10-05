<?php

namespace Scrilex\Entity;

/**
 * @Entity(repositoryClass="Scrilex\Entity\TaskHistoryRepository")
 * @Table(name="task_history")
 */
class TaskHistory {
    
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    
    /**
     * @ManyToOne(targetEntity="Task", inversedBy="histories")
     */
    protected $task;
    
    /**
     * @ManyToOne(targetEntity="User", inversedBy="histories")
     */
    protected $user;
    
    /**
     * @Column(type="datetime")
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