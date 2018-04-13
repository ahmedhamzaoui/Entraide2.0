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

class rechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  ->add('typeobjPerdu', ChoiceType::class, array('choices'=>array(''=>'','Calculatrice'=>'Calculatrice','Chargeur'=>'Chargeur','Clés'=>'Clés','Clé USB'=>'Clé USB','CIN'=>'CIN','Monnaie'=>'Monnaie','Passeport'=>'Passeport','PC'=>'PC','Porte-feuilles'=>'Porte-feuilles','Porte-documents'=>'Porte-documents','Telephone'=>'Telephone','Feuilles'=>'Feuilles','Autre'=>'Autre')))
            ->add('type', ChoiceType::class, array('choices'=>array(''=>'','Reclamation Objet Perdu'=>'Reclamation Objet Perdu','Reclamation Objet Trouvé'=>'Reclamation Objet Trouvé')))
            ->add('Rechercher',SubmitType::class);
    }
}