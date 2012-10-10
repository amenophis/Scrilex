<?php

namespace Scrilex\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\SerializerBundle\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="Scrilex\Entity\ProjectRepository")
 * @ORM\Table(name="project")
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="project")
     * @ORM\OrderBy({"pos" = "ASC"})
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