<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //TODO faire la validation du formulaire
            ->add('nom')
            ->add('dateHeureDebut',
                DateType::class, [
                    'html5' => true,
                    'widget'=>'single_text'
                ]
            )
            ->add('duree')
            ->add('dateLimiteInscription',
                DateType::class, [
                    'html5' => true,
                    'widget'=>'single_text'
                ])
            ->add('nombreInscriptionMax')
            ->add('infosSortie');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
