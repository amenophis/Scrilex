<?php

namespace Scrilex\Entity;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
 
class UserRepository extends \Amenophis\UserAdmin\Entity\UserRepository
{

    public function loadUserByUsername($username) {
        $user = $this->findOneBy(array('username' => strtolower($username)));
        if (!$user) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
        return $user;
    }

    public function refreshUser(UserInterface $user) {
        if (!$user instanceof \Scrilex\Entity\User) {
            throw new \Symfony\Component\Security\Core\Exception\UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        return $class === 'Scrilex\Entity\User';
    }
}
