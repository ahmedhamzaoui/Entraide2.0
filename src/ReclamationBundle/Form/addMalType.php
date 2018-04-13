<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 23/03/2018
 * Time: 22:18
 */

namespace ReclamationBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class addMalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('matricule')
            ->add('photo2',FileType::class)
            ->add('Ajouter',SubmitType::class);
    }
}