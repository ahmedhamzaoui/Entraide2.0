<?php

namespace GestionCovoiturageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReserverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nbplaces',ChoiceType::class, array(
            'choices'=>array(
                '1 place'=>'1',
                '2 places'=>'2',
                '3 places'=>'3',
                '4 places '=>'4',
            )
        ))
            ->add('Reserver',SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionCovoiturageBundle\Entity\Reservationcovoiturage'
        ));
    }

    public function getBlockPrefix()
    {
        return 'gestioncovoituragebundle_Reservationcovoiturage';
    }
}
