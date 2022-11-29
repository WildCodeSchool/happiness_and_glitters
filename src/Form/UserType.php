<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', null, ['label' => false, 'attr' => ['placeholder' => 'Prénom']])
            ->add('lastname', null, ['label' => false, 'attr' => ['placeholder' => 'Nom']])
            ->add('email', null, ['label' => false, 'attr' => ['placeholder' => 'Email']])
            ->add('nickname', null, ['label' => false, 'attr' => ['placeholder' => 'Pseudo']])
            ->add('password', PasswordType::class, ['label' => false])
            ->add('password', RepeatedType::class, [
                'required' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les Mots de passe doivent être identiques',
                'options' => ['attr' => ['placeholder' => 'Mot de passe']],
                'first_options'  => ['label' => false],
                'second_options' => ['label' => false],
                'mapped' => false
            ])
            ->add('avatarFile', VichFileType::class, [
                'label' => false,
                'required'      => false,
                'allow_delete'  => false, // not mandatory, default is true
                'download_uri' => false, // not mandatory, default is true
            ])
            ->add('description', null, ['label' => false, 'attr' => ['placeholder' => 'Descris-toi']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
