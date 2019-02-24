<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mail', EmailType::class,[
                'label' => 'Email',
                'attr' =>[
                    'placeholder' => 'Entrer votre email'
                ]
            ])
            ->add('password',PasswordType::class,[
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' =>'Entrer votre mot de passe'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label' =>'Connexion',
                'attr' =>[
                    'class' => 'btn-form'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', null);
    }

    public function getBlockPrefix()
    {
        return 'app_login';
    }
}
