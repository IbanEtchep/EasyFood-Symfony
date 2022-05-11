<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mailU', EmailType::class, ['label' => 'Email'])
            ->add('nomU', TextType::class, ['label' => 'Nom'])
            ->add('prenomU', TextType::class, ['label' => 'Prénom'])
            ->add('numAdrC', TextType::class, ['label' => 'Numéro de rue'])
            ->add('rueC', TextType::class, ['label' => 'Rue'])
            ->add('cpC', TextType::class, ['label' => 'Code Postal'])
            ->add('villeC', TextType::class, ['label' => 'Ville'])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "J'acceptes les termes.",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devriez accepter les termes.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'label' => ' ',
                'mapped' => false,
                'first_options'  => array(
                'label' => 'Mot de passe',
                    'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un mot de passe",
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ]),
                'second_options' => array('label' => 'Répétez le mot de passe'),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
