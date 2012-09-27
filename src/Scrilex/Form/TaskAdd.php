<?php

namespace Scrilex\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskAdd extends AbstractType
{
    public function getName()
    {
        return 'task';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', 'text');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Scrilex\Entity\Task'
        ));
    }
}