<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 06/04/2018
 * Time: 01:07
 */

namespace ColocationBundle\Form;


use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReserverType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbplace')
            ->add('date_res' ,DateType::class,array(
                'widget'=>'single_text',))
            ->add('Reserver',SubmitType::class);


    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ColocationBundle\Entity\Reservationcolocation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'colocationbundle_Reservationcolocartion';
    }


}