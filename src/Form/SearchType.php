<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*
         * Constrution du formulaire qui va nous servir de recherche
         */
        $builder
            ->add(
            'q',
            TextType::class,[
                'label'=> false,
                'required'=>false,
            ])
            ->add('campus', EntityType::class,[
                'label'=> false,
                'required'=>false,
                'class'=> Campus::class,
                'choice_label'=>'nom'
            ])
            ->add('isInscrit', CheckboxType::class,[
                'label'=>'Êtes vous inscrit à cette sortie?',
                'required'=>false
            ])
        ;
    }

    /*
     * Permet de configurer les options liés au formulaire
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //c'ets la class SearchData qui va représenter nos données
            'data_class'=>SearchData::class,
            //le formulaire utilisera une méthode GET par defaut
            //les paramètres vont passer par l url pour que l utilisateur puisse partager une recherche
            'method'=> 'GET',
            //désactivation de la protaction car pas de soucis de cross scripting
            'csrf_protection'=>false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}