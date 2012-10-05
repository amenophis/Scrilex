<?php

namespace Scrilex\Entity;

use \Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Entity(repositoryClass="Scrilex\Entity\UserRepository")
 * @Table(name="user")
 */
class User extends \Amenophis\Entity\User {

    /**
     * @OneToMany(targetEntity="Task", mappedBy="user")
     * @OrderBy({"pos" = "ASC"})
     */
    protected $tasks;
    
    public function getRoles(){ return $this->roles; }
    
    public function setRoles($roles) { $this->roles = $roles; return $this; }
    
    public function serialize() {
        $array = array(
            'roles' => $this->roles
        );
        
        return parent::serialize($array);
    }
    
    public function unserialize($data) {
        $datas = parent::unserialize($data);
        $this->roles = $datas['roles'];
    }
}