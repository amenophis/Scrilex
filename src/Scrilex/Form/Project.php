<?php

namespace Scrilex\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Project extends AbstractType
{
    public function getName()
    {
        return 'project';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_constraint' => function(Options $options, $value) {
                return new Assert\Collection(array(
                    'fields' => array(
                        'name' => array(
                            new Assert\NotBlank(),
                            new Assert\MaxLength(array('limit' => 255))
                        )
                    )
                ));
            }
        ));
    }
}