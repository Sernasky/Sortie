<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'attr' => array(
                    'placeholder' => 'exemple@gmail.com'
                ),
                'label' => 'Adresse Mail',
                'required' => false,
    ])
            ->add('pseudo', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Votre pseudo'
                ),
                'label' => 'Pseudo',
                'required' => false,
            ])
            ->add('firstname', TextType::class, [
        'attr' => array(
            'placeholder' => 'Votre prénom'
        ),
        'label' => 'Prénom',
        'required' => false,
    ])
            ->add('lastname', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Votre nom'
                ),
                'label' => 'Nom',
                'required' => false,
            ])
            ->add('telephone', TextType::class, [
                'attr' => array(
                    'placeholder' => '0123456789',
                ),
                'label' => 'Numéro de Téléphone',
                'required' => false,
            ])
            ->add('campus', EntityType::class,[
                'label'=> "Campus",
                'class'=>Campus::class,
                'choice_label'=>'nom'])
            ->add('plainPassword', PasswordType::class, [
                'label'=> "Mot de passe",
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
