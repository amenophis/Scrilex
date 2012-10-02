<?php

namespace Scrilex\Entity;

/**
 * @Entity(repositoryClass="Scrilex\Entity\TaskRepository")
 * @Table(name="task")
 */
class Task {
    
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
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
     * @Column(type="integer")
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
    
    public function getId() { return $this->id; }
    public function getProject() { return $this->project; }
    public function getUser() { return $this->user; }
    public function getPos() { return $this->pos; }
    public function getCol() { return $this->col; }
    public function getSeverity() { return $this->severity; }
    public function getContent() { return $this->content; }
    
    public function setId($id) { $this->id = $id; return $this; }
    public function setProject($project) { $this->project = $project; return $this; }
    public function setUser($user) { $this->user = $user; return $this; }
    public function setPos($pos) { $this->pos = $pos; return $this; }
    public function setCol($col) { $this->col = $col; return $this; }
    public function setSeverity($severity) { $this->severity = $severity; return $this; }
    public function setContent($content) { $this->content = $content; return $this; }
}