<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\TicketEntity;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\TicketFormType;
use App\Service\PublicForm;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/reg', name: "reg")]
    public function reg(Request $request, PublicForm $userForm, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $userForm->create($user,RegistrationFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setUsername($form->get('username')->getData());
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('admin');
        }
        $array = [
            'form' => $form->createView(),
            'title' => 'Регистрация пользователя',
            'toWhere' => 'login',
            'method' => 'POST'
        ];
        return $this->render('ticket/auth.html.twig', $array);
    }
    #[Route('/edit/{id}')]
    public function edit(int $id,Request $request, EntityManagerInterface $manager, PublicForm $form, LoggerInterface $logger) {
        $ticket = $manager->getRepository(TicketEntity::class)->find($id);
        $form = $form->create($ticket, TicketFormType::class);
        $form->handleRequest($request);
        $message = "";
        if ($form->isSubmitted() && $form->isValid()) {
            $logger->info($ticket->getName());
            $ticket->setStatus($form->get('status')->getData());
            $manager->flush();
            return $this->redirectToRoute('admin');
        }
        $array = [
            'form' => $form->createView(),
            'title' => 'Изменить тикет ',
            'ticket' => $ticket,
        ];
        return $this->render('ticket/add-ticket.html.twig',
            $array
        );
    }
    #[Route('/admin', name: 'admin')]
    public function admin(EntityManagerInterface $manager) {
        $ticketsOfUser = $manager->getRepository(TicketEntity::class)->findAll();
        $array = [
            'ticketsOfUser' => $ticketsOfUser,
            'title' => 'Все тикеты тикеты пользователя',
        ];
        return $this->render('ticket/list.html.twig',
            $array
        );
    }
}