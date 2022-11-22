<?php

namespace App\Form\Admin;

use App\Entity\Attack;
use App\Entity\Unicorn;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('avatar', FileType::class, [
                "required" => false
            ])
            ->add('cost')
            ->add('gain')
            ->add('successRate')
            ->add('unicorns', EntityType::class, [
                "class" => Unicorn::class,
                "multiple" => true,
                "expanded" => true,
                "choice_label" => "name"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Attack::class,
        ]);
    }
}
