<?php
namespace Scrilex\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserAdd extends AbstractType
{
    public function getName(){
        return 'user';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text');
        $builder->add('firstname', 'text');
        $builder->add('lastname', 'text');
        //$builder->add('password_new', 'password', array('property_path' => false));
        //$builder->add('password_confirm', 'password', array('property_path' => false));
        //$builder->add('password2', 'password');
        //$builder->add('roles', 'text');
        
        return $builder;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Scrilex\Entity\User'
        ));
    }
}