<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 23/03/2018
 * Time: 16:27
 */

namespace ReclamationBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class rechercheMalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('matricule')
            ->add('Rechercher',SubmitType::class);
    }
}