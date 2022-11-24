<?php

namespace App\Form\Admin;

use App\Entity\Unicorn;
use App\Entity\Attack;
use App\Service\AvatarUploader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UnicornType extends AbstractType
{
    public function __construct(private AvatarUploader $avatarUploader)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('avatar', FileType::class, [
                "required" => false,
                "data_class" => null,
                "constraints" => new File([
                    'maxSize' => $this->avatarUploader->getMaxFileSize(),
                    'mimeTypes' => $this->avatarUploader->getAuthorizedMimeTypes()
                ])
            ])
            ->add('score')
            ->add('fights')
            ->add('wonFights')
            ->add('lostFights')
            ->add('koFights')
            ->add('attacks', EntityType::class, [
                "class" => Attack::class,
                "multiple" => true,
                "expanded" => true,
                "choice_label" => "name"
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
