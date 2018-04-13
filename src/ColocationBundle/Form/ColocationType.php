<?php

namespace ColocationBundle\Form;

use blackknight467\StarRatingBundle\Form\RatingType;
use\Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColocationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class)

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
            ->add('prix',NumberType::class)
            ->add('nbchambre',NumberType::class)
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
            ->add('nbpersonne',NumberType::class)
            ->add('adresse')
            ->add('photo',FileType::class)
            ->add('Ajouter',SubmitType::class );

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
