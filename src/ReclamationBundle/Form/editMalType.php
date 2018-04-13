<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 21/03/2018
 * Time: 15:00
 */

namespace ReclamationBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class editMalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('matricule')
            ->add('photo2',FileType::class ,array('label'=>'Image','data_class'=>null))
            ->add('Modifier',SubmitType::class)
            ->setMethod('POST');
    }
}