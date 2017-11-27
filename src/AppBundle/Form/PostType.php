<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('thumb')
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy H:mm',
                'attr'  => [
                    'class' => 'js-datepicker'
                ],
                'html5' => false
            ])
            ->add('updatedAt', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy H:mm',
                'attr'  => [
                    'class' => 'js-datepicker'
                ],
                'html5' => false
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_post';
    }


}
