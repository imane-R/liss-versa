<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\HairType;
use App\Entity\PriceByHair;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PriceByHairType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix')
            ->add('service', EntityType::class, [
                'label' => 'Choisissez un service',
                'class' => Service::class,
                'choice_label' => 'titre',
                'expanded' => true,
                'multiple' => false
            ])
            ->add('hairType', EntityType::class, [
                'label' => 'Choisissez cheveux type',
                'class' => HairType::class,
                'choice_label' => 'typeHair',
                'expanded' => true,
                'multiple' => false
            ])
            ->add('envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PriceByHair::class,
        ]);
    }
}
