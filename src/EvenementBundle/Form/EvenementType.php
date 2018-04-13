<?php

namespace EvenementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class)
            ->add('date',DateType::class,array(
                'widget'=>'single_text',
                'attr' => array(
                    'min' => date('Y-m-d')
                )

            ))
            ->add('heure',TimeType::class,array(
                'widget'=>'single_text'
            ))
            ->add('lieu',TextType::class)
            ->add('photo',FileType::class, array(
                'required' => false,
                'data_class'=>null,


            ))
            ->add('type',ChoiceType::class,array(
                'choices'=>array(
                    'Interne'=>'Interne',
                    'Externe'=>'Externe'
                )
            ))
            ->add('nbreDispo',NumberType::class)
            ->add('description',TextareaType::class)
            ->add('payant',ChoiceType::class,array(
                'choices'=> array(
                    'payant'=>1,
                    'gratuit'=>0
                ),
                'multiple' => false,

                'expanded'=>true,
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EvenementBundle\Entity\Evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'evenementbundle_evenement';
    }


}
