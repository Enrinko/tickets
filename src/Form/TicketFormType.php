<?php

namespace App\Form;

use App\Entity\Status;
use App\Entity\TicketEntity;
use App\Entity\UrgencyEntity;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Дайте название тикету',
                'attr' => [
                    'placeholder' => 'Название'
                ]
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Опишите свою проблему',
                'attr' => [
                    'placeholder' => 'Проблема'
                ],
            ])
            ->add('urgency', EntityType::class, [
                'class' => UrgencyEntity::class,
                'choice_label' => 'time',
                'placeholder' => 'В часах',
                'label' => 'Как срочно нужна помощь'

            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'status',
                'label' => 'Смена статуса'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TicketEntity::class,
        ]);
    }
}