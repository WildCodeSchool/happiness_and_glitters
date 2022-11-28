<?php

namespace App\Form\Admin;

use App\Entity\Attack;
use App\Entity\Unicorn;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class AttackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('avatarFile', VichFileType::class, [
                "required" => false,
                "allow_delete" => true,
                "download_uri" => false
            ])
            ->add('cost')
            ->add('gain')
            ->add('unicorns', EntityType::class, [
                "class" => Unicorn::class,
                "choice_label" => "name",
                "multiple" => true,
                "expanded" => true
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
