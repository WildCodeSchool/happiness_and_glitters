<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', null, ['label' => false, 'attr' => ['placeholder' => 'Prénom']])
            ->add('lastname', null, ['label' => false, 'attr' => ['placeholder' => 'Nom']])
            ->add('email', null, ['label' => false, 'attr' => ['placeholder' => 'Email']])
            ->add('nickname', null, ['label' => false, 'attr' => ['placeholder' => 'Pseudo']])
            ->add('password', PasswordType::class, ['label' => false, 'attr' => ['placeholder' => 'Mot de passe']])
            ->add('avatar', FileType::class, ['label' => false, 'attr' => ['label' => 'Photo ou Avatar']])
            ->add('description', null, ['label' => false, 'attr' => ['placeholder' => 'Descris-toi']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
