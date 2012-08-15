<?php

namespace Scrilex\Entity;

/**
 * @Entity(repositoryClass="Scrilex\Repository\Task")
 */
class Task {
    
    /**
     * @Id
     * @Column(type="integer")
     * @generatedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @OneToOne(targetEntity="Scrilex\Entity\Project")
     * @JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;
    
    /**
     * @OneToOne(targetEntity="Scrilex\Entity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    /**
     * @Column(type="integer"
     */
    protected $pos;
    
    /**
     * @Column(type="integer", nullable=false)
     */
    protected $col;
    
    /**
     * @Column(type="integer", nullable=false)
     */
    protected $severity;
    
    /**
     * @Column(type="string", nullable=false)
     */
    protected $content;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getProjectId()
    {
        return $this->project_id;
    }
    
    public function getUserId()
    {
        return $this->project_id;
    }
    
    public function getPos()
    {
        return $this->pos;
    }
    
    public function getCol()
    {
        return $this->col;
    }
    
    public function getSeverity()
    {
        return $this->severity;
    }
    
    public function getContent()
    {
        return $this->content;
    }
}