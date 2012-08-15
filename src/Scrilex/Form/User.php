<?php

namespace Scrilex\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class User extends AbstractType
{
    public function getName()
    {
        return 'user';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text');
        $builder->add('firstname', 'text');
        $builder->add('lastname', 'text');
        $builder->add('password', 'text');
        $builder->add('roles', 'text');
        $builder->add('is_manager', 'checkbox');
        return $builder;
    }

    public function getDefaultOptions(array $options)
    {
        $collectionConstraint = new Assert\Collection(array(
            'allowExtraFields' => true,
            'fields' => array(
                'username' => array(
                    new Assert\NotBlank(),
                    new Assert\MinLength(array('limit' => 5)),
                    new Assert\MaxLength(array('limit' => 20))
                ),
                'firstname' => new Assert\NotBlank(),
                'lastname' => new Assert\NotBlank(),
                'password' => new Assert\NotBlank(),
                'roles' => new Assert\NotBlank()
            )
        ));

        return array('validation_constraint' => $collectionConstraint);
    }
}