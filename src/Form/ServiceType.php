<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])
            ->add('description', null, [
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])
            ->add('imageForm', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Ajouter une image',
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])
            ->add('categorie', EntityType::class, [
                'label' => 'Choisissez un categorie',
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('cheveuxCourtsPrix', null, [
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])
            ->add('cheveuxMoyensPrix', null, [
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])
            ->add('cheveauxLongsPrix', null, [
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])
            ->add('envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'buttonForm'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
