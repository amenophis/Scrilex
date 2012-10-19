<?php

namespace Scrilex\Entity;

use \Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Scrilex\Entity\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends \Amenophis\UserAdmin\Entity\User {

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="user")
     * @ORM\OrderBy({"pos" = "ASC"})
     */
    protected $tasks;
    
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
    
    public function toArray()
    {
        return array(
            'id' => $this->id,
            'username' => $this->username,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'roles' => $this->roles
        );
    }
    
    public function fromArray($array)
    {
        $this->setFirstname($array['firstname'])
            ->setLastname($array['lastname'])
            ->setRoles($array['roles']);
    }
}