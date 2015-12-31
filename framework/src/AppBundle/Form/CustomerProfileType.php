<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CustomerProfileType
 *
 * @package AppBundle\Form
 */
class CustomerProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('displayName', 'text')
            ->add('avatarData', 'text', array('mapped' => false))
            ->add('avatarMimeType', 'text', array('mapped' => false));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CustomerProfile',
            'csrf_protection' => false,
            'method' => 'PUT'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
