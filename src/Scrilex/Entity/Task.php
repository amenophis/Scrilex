<?php

namespace Scrilex\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\SerializerBundle\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="Scrilex\Entity\TaskRepository")
 * @ORM\Table(name="task")
 */
class Task {
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("integer")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="tasks")
     * 
     * @JMS\Type("Project")
     */
    protected $project;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
     * 
     * @JMS\Type("Scrilex\Entity\User")
     */
    protected $user;
    
    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("integer")
     */
    protected $pos;
    
    /**
     * @ORM\Column(type="integer", nullable=false)
     * 
     * @JMS\Type("integer")
     */
    protected $col;
    
    /**
     * @ORM\Column(type="integer", nullable=false)
     * 
     * @JMS\Type("integer")
     */
    protected $severity;
    
    /**
     * @ORM\Column(type="string", nullable=false)
     * 
     * @JMS\Type("string")
     */
    protected $content;
    
    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="task")
     * 
     * @JMS\Type("ArrayCollection<Scrilex\Entity\TaskHistory>")
     */
    protected $histories;
    
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