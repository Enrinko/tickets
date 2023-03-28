<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Имя пользователя',
                'attr' => [
                    'placeholder' => 'Имя пользователя'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Пароль',
                'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Пароль',],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('captcha', ReCaptchaType::class, [])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'just_LogIn',
        ]);
    }
}
