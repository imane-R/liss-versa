<?php

namespace App\Form;

use App\Entity\Mletpc;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MletpcType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mentionslegales', CKEditorType::class, [
                'config' => [
                    'uiColor' => '#FFFFFF',
                ]
            ])
            ->add('politiquesdeconfidentialite', CKEditorType::class, [
                'config' => [
                    'uiColor' => '#FFFFFF',
                ]
            ])
            ->add('envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'buttonForm'
                ]
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mletpc::class,
        ]);
    }
}
