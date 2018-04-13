<?php

namespace ColocationBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifierType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')

            ->add('typeLog', ChoiceType::class, array(
                'choices' => array(
                    'Appartement'=>'Appartement',
                    'Studio'=>'Studio',
                    'Maison'=>'Maison',
                    'Chambre'=>'Chambre'
                )

            ))
            ->add('meuble',ChoiceType::class,array('multiple'=>false,
                'label'=>'Meublé',
                'expanded'=>true,'choices'  => array(
                    'oui' => 'oui',
                    'non' => 'non')))
            ->add('prix')
            ->add('nbchambre')
            ->add('etage', ChoiceType::class, array(
                'choices' => array(
                    'RDC'=>'RDC',
                    '1'=>'1',
                    '2'=>'2',
                    '3'=>'3',
                    '4'=>'4',
                    '5'=>'5',
                )

            ))
            ->add('dateDispo',DateType::class,array(
                'widget'=>'single_text',
            ))
            ->add('nbpersonne')
            ->add('adresse')

            ->add('Modifier',SubmitType::class);

    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ColocationBundle\Entity\Colocation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'colocationbundle_colocation';
    }


}
