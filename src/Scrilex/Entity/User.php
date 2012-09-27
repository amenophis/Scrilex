<?php

namespace Scrilex\Entity;

use \Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Entity(repositoryClass="Scrilex\Entity\UserRepository")
 * @Table(name="user")
 */
class User implements UserInterface, \Serializable {

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $username;
    
    /**
     * @Column(type="string", length=255, nullable=false)
     */
    protected $password;
    
    /**
     * Column(type="string", length="255")
     *
     * @var string salt
     */
    protected $salt;
    
    /**
     * @Column(type="string", nullable=false)
     */
    protected $firstname;
    
    /**
     * @Column(type="string", nullable=false)
     */
    protected $lastname;
        
    /**
     * @Column(type="array")
     * @var type 
     */
    protected $roles;
    
    public function __construct()
    {
        $this->roles = array();
    }    
    
    /**
     * Gets the user roles.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
 
    /**
     * Compares this user to another to determine if they are the same.
     * 
     * @param UserInterface $user The user
     * @return boolean True if equal, false othwerwise.
     */
    public function equals(UserInterface $user)
    {
        return md5($this->getUsername()) == md5($user->getUsername());
    }
    
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
            //'is_manager'  => $this->is_manager ? 1 : 0,
            'roles'     => $this->roles
        ));
    }
    
    public function unserialize($data) {
        $datas = unserialize($data);
        $this->username = $datas['username'];
        $this->password = $datas['password'];
        $this->lastname = $datas['lastname'];
        $this->firstname = $datas['firstname'];
        //$this->is_manager = $datas['is_manager'] == 1;
        $this->roles = $datas['roles'];
    }
}