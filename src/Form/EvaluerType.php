<?php

namespace App\Form;

use App\Entity\Evaluer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EvaluerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('noteQualiteNourriture',
                        IntegerType::class,
                        ['required' => true,
                        'attr' => ['min' => 0,'max' => 5]])
                ->add('noteRespectRecette',
                        IntegerType::class,
                        ['required' => true,
                        'attr' => ['min' => 0,'max' => 5]])
                ->add('noteEsthetique',
                        IntegerType::class,
                        ['required' => true,
                        'attr' => ['min' => 0,'max' => 5]])
                ->add('noteCout',
                        IntegerType::class,
                        ['required' => true,
                        'attr' => ['min' => 0,'max' => 5]])
                ->add('commentaireEvaluation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Evaluer::class,
        ]);
    }

}
