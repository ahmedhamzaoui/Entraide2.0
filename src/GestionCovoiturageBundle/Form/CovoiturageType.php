<?php

namespace GestionCovoiturageBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class CovoiturageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('depart')
            ->add('arrive')
            ->add('prix'
            )
            ->add('date',DateType::class,array(
                'widget'=>'single_text',))

            ->add('heure',TimeType::class,array(
                'widget'=>'single_text',
            ))
            ->add('nbrplaces')
            ->add('comfort',ChoiceType::class,array(
                'choices'=>array(
                    'Basique'=>'Basique',
                    'Normal'=>'Normal' ,
                    'Comfortable'=>'Comfortable',
                    'Luxe'=>'Luxe'
                )
            ))
        ->add('fumeur',ChoiceType::class,array('multiple'=>false,
            'label'=>'Fumeur',
            'expanded'=>true,'choices'  => array(
                'oui' => 'oui',
                'non' => 'non')))
        ->add('Modifier',SubmitType::class);

}

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'GestionCovoiturageBundle\Entity\Covoiturage'
    ));
}

public function getBlockPrefix()
{
    return 'gestioncovoituragebundle_covoiturage';
}
}
