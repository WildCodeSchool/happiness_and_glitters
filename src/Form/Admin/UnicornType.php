<?php

namespace App\Form\Admin;

use App\Entity\Unicorn;
use App\Entity\Attack;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class UnicornType extends AbstractType
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
            ->add('attacks', EntityType::class, [
                "class" => Attack::class,
                "multiple" => true,
                "expanded" => true,
                "choice_label" => "name",
                "by_reference" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Unicorn::class,
        ]);
    }
}
