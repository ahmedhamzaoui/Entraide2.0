<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 10/04/2018
 * Time: 23:02
 */

namespace ReclamationBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class rechaffichertoutesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('type', ChoiceType::class, array('choices'=>array(''=>'','Reclamation Objet Perdu'=>'Reclamation Objet Perdu','Reclamation Objet Trouvé'=>'Reclamation Objet Trouvé')))
            ->add('Rechercher',SubmitType::class);
    }
}