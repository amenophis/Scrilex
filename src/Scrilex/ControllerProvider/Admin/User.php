<?php

namespace Scrilex\ControllerProvider\Admin;

use Silex\Application;

class User extends \Amenophis\UserAdmin\ControllerProvider\AdminUser {

    public function connect(Application $app) {
        $controllers = parent::connect($app);
        
        return $controllers;
    }
}