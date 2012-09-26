<?php

namespace Scrilex\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Entity
 */
class Role extends RoleInterface
{
     /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;
 
    /**
     * @Column(type="string", length="255")
     */
    protected $name;    
 
    /**
     * Gets the id.
     */
    public function getId()
    {
        return $this->id;
    }
 
    /**
     * Gets the role name.
     */
    public function getName()
    {
        return $this->name;
    }
 
    /**
     * Sets the role name.
     */
    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }
 
    /**
     * Consturcts a new instance of Role.
     */
    public function __construct()
    {
    }
 
    /**
     * Implementation of getRole for the RoleInterface.
     */
    public function getRole()
    {
        return $this->getName();
    }
}