<?php

namespace Scrilex\Entity;

use \Symfony\Component\Security\Core\User\UserInterface;

// foo : 5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==
// array('ROLE_ADMIN') : a:1:{i:0;s:10:"ROLE_ADMIN";}

/**
 * @Entity(repositoryClass="Scrilex\Entity\UserRepository")
 * @Table(name="user")
 */
class User implements UserInterface, \Serializable {

    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
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
    
    /**
     * @OneToMany(targetEntity="Task", mappedBy="user")
     * @OrderBy({"pos" = "ASC"})
     */
    protected $tasks;
    
    public function __construct()
    {
        $this->roles = array();
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getFirstname() { return $this->firstname; }
    public function getLastname() { return $this->lastname; }
    public function getPassword() { return $this->password; }
    public function getSalt() { return null; }
    
    public function setId($id) { $this->id = $id; return $this; }
    public function setUsername($username) { $this->username = $username; return $this; }
    public function setFirstname($firstname) { $this->firstname = $firstname; return $this; }
    public function setLastname($lastname) { $this->lastname = $lastname; return $this; }
    public function setPassword($password) { $this->password = $password; return $this; }
    public function setSalt($salt) { return null; }
    
    public function eraseCredentials() { return true; }
    
    public function serialize() {
        return serialize(array(
            'username'  => $this->username,
            'password'  => $this->password,
            'lastname'  => $this->lastname,
            'firstname'  => $this->firstname,
            'roles'     => $this->roles
        ));
    }
    
    public function unserialize($data) {
        $datas = unserialize($data);
        $this->username = $datas['username'];
        $this->password = $datas['password'];
        $this->lastname = $datas['lastname'];
        $this->firstname = $datas['firstname'];
        $this->roles = $datas['roles'];
    }
}