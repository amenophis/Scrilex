<?php

namespace Scrilex\Entity;

/**
 * @Entity(repositoryClass="Scrilex\Entity\ProjectRepository")
 * @Table(name="project")
 */
class Project
{
    /**
     * @Id
     * @Column(type="integer")
     * @generatedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $name;
    
    
    /**
     * @OneToMany(targetEntity="Scrilex\Entity\Task", mappedBy="project")
     * @OrderBy({"pos" = "ASC"})
     */
    protected $tasks;
    
    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getTasks() { return $this->tasks; }
    
    public function setName($name) { $this->name = $name; return $this; }
    public function addTask(Task $task) { $this->tasks->add($task); return $this; }
    
    public function getTasksByColumn($column) {
        $tasks = array();
        foreach($this->tasks as $task)
        {
            if($task->getCol() == $column) $tasks[] = $task;
        }
        return $tasks;
    }
}