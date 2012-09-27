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
     */
    protected $tasks;
    
    /**
     * @OneToMany(targetEntity="Scrilex\Entity\Task", mappedBy="project")
     */
    protected $tasks_1;
    
    /**
     * @OneToMany(targetEntity="Scrilex\Entity\Task", mappedBy="project")
     */
    protected $tasks_2;
    
    /**
     * @OneToMany(targetEntity="Scrilex\Entity\Task", mappedBy="project")
     */
    protected $tasks_3;
    
    /**
     * @OneToMany(targetEntity="Scrilex\Entity\Task", mappedBy="project")
     */
    protected $tasks_4;
    
    /**
     * @OneToMany(targetEntity="Scrilex\Entity\Task", mappedBy="project")
     */
    protected $tasks_archive;
    
    
    
    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function getTasks()
    {
        return $this->tasks;
    }
    
    public function getTasksByColumn($column)
    {
        return array();
    }
}