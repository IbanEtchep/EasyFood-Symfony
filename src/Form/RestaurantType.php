<?php

namespace App\Form;

use App\Entity\Resto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomR')
            ->add('numAdrR')
            ->add('rueAdrR')
            ->add('cpR')
            ->add('villeR')
            ->add('heureOuverture')
            ->add('heureFermeture')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Resto::class,
        ]);
    }
}
