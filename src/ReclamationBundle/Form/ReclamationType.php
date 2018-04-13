<?php

namespace ReclamationBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use ReclamationBundle\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description', CKEditorType::class)
         ->add('dateDecouverte',DateType::class,array(
             'widget'=>'single_text',
         ))
            ->add('lieuDecouverte', ChoiceType::class, array('choices'=>array(''=>'','esprit ghazela'=>'esprit ghazela','esprit charguia'=>'esprit charguia')), array('attr'=>array('style'=>'width:300px','class'=>'select-option')))
            ->add('typeobjPerdu', ChoiceType::class, array('choices'=>array(''=>'','Calculatrice'=>'Calculatrice','Chargeur'=>'Chargeur','Carte Etudiant'=>'Carte Etudiant','Clés'=>'Clés','Clé USB'=>'Clé USB','CIN'=>'CIN','Monnaie'=>'Monnaie','Passeport'=>'Passeport','PC'=>'PC','Porte-feuilles'=>'Porte-feuilles','Porte-documents'=>'Porte-documents','Telephone'=>'Telephone','Feuilles'=>'Feuilles','Autre'=>'Autre')))
            ->add('autretypeobjPerdu')
            ->add('type', ChoiceType::class, array('choices'=>array(''=>'','Reclamation Objet Perdu'=>'Reclamation Objet Perdu','Reclamation Objet Trouvé'=>'Reclamation Objet Trouvé')))
            ->add('localisation', ChoiceType::class, array('choices'=>array(''=>'','Buvette'=>'Buvette','Bloc A'=>'Bloc A','Bloc B'=>'Bloc B','Bloc C'=>'Bloc C','Bloc D'=>'Bloc D','Bloc E'=>'Bloc E','Bloc F'=>'Bloc F','Bloc H'=>'Bloc H','Autre'=>'Autre')))
            ->add('autrelocalisation')
            ->add('etage', ChoiceType::class, array('choices'=>array(''=>'','Rez-de-chaussée'=>'Rez-de-Chaussée','1er étage'=>'1er étage','2éme étage'=>'2éme étage','3éme étage'=>'3éme étage','4éme étage'=>'4éme étage')))
            ->add('salle')
            ->add('photo',FileType::class)
            ->add('Ajouter',SubmitType::class);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Reclamation::class
        ));}


        /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'reclamationbundle_reclamation';
    }


}
