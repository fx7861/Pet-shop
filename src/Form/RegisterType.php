<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom'
                ]])
            ->add('username', TextType::class, [
                'label' => 'Prenom',
                'attr' => [
                    'placeholder' => 'Prenom'
                ]])
            ->add('mail', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email'
                ]])
            ->add('adress', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Adresse'
                ]])
            ->add('postal_code', TextType::class, [
                'label' => 'Code Postal',
                'attr' => [
                    'placeholder' => 'Code Postal'
                ]])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Ville'
                ]])
            ->add('phone', TelType::class, [
                'required' => false,
                'label' => 'Telephone',
                'attr' => [
                    'onkeypress' => 'return verif(event)',
                    'placeholder' => 'Numéro de téléphone'
                ]])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe'
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire",
                'attr' => [
                    'class' => 'btn-form'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
