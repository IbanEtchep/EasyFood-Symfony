<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomU')
            ->add('prenomU')
            ->add('mailU')
            ->add('numAdrC')
            ->add('rueC')
            ->add('cpC')
            ->add('villeC')
            ->add('noteEasyFood')
            ->add('commentaireEasyFood')
            ->add('commentaireVisible')
            ->add('commentaireModere')
            //->add('mdpU')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
