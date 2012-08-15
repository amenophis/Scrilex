<?php

namespace Scrilex\Entity;

use \Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Entity(repositoryClass="Scrilex\Repository\User")
 */
class User implements UserInterface, \Serializable {

    /**
     * @Id
     * @Column(type="integer")
     * @generatedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @Column(type="string", length=32, unique=true, nullable=false)
     */
    private $username;
    
    /**
     * @Column(type="string", length=255, nullable=false)
     */
    private $password;
    
    /**
     * @Column(type="string", nullable=false)
     */
    private $firstname;
    
    /**
     * @Column(type="string", nullable=false)
     */
    private $lastname;
    
    /**
     * @Column(type="boolean")
     */
    private $is_manager;
    
    /**
     * @Column(type="string", nullable=false)
     */
    private $roles;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    public function getIsManager()
    {
        return $this->is_manager;
    }
    
    public function getLastname()
    {
        return $this->lastname;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getRoles()
    {
        return explode(',', $this->roles);
    }
    
    public function getSalt()
    {
        return null;
    }
    
    public function eraseCredentials()
    {
        return true;
    }
    
    public function serialize() {
        return serialize(array(
            'username'  => $this->username,
            'password'  => $this->password,
            'lastname'  => $this->lastname,
            'firstname'  => $this->firstname,
            'is_manager'  => $this->is_manager ? 1 : 0,
            'roles'     => $this->roles
        ));
    }
    
    public function unserialize($data) {
        $datas = unserialize($data);
        $this->username = $datas['username'];
        $this->password = $datas['password'];
        $this->lastname = $datas['lastname'];
        $this->firstname = $datas['firstname'];
        $this->is_manager = $datas['is_manager'] == 1;
        $this->roles = $datas['roles'];
    }
}