<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\TicketEntity;
use App\Entity\TicketOfUser;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\TicketFormType;
use App\Service\PublicForm;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    public PublicForm $publicForm;
    public EntityManagerInterface $entityManager;

    public function __construct(PublicForm $publicForm, EntityManagerInterface $entityManager)
    {
        $this->publicForm = $publicForm;
        $this->entityManager = $entityManager;
    }

    #[Route('/ticket/add', name: 'add')]
    public function add(Request $request, LoggerInterface $logger): Response
    {
        $ticket = new TicketEntity();
        $form = $this->publicForm->create($ticket, TicketFormType::class);
        $form->handleRequest($request);
        $message = "";
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $ticket->setText($form->get('text')->getData());
            $ticket->setName($form->get('name')->getData());
            $ticket->setStatus($this->entityManager->getRepository(Status::class)->find('2'));
            $ticket->setUrgency($form->get('urgency')->getData());
            $this->entityManager->getRepository(TicketEntity::class)->save($ticket);
            $this->entityManager->flush();
            $ticketOfUser = new TicketOfUser();
            $ticketOfUser->setTicket($ticket);
            $ticketOfUser->setUser($this->entityManager->getRepository(User::class)->findOneBy(['username' => $this->getUser()->getUserIdentifier()]));
            $logger->info($ticketOfUser->getUser()->getUserIdentifier());
            $this->entityManager->getRepository(TicketOfUser::class)->save($ticketOfUser);
            $this->entityManager->flush();
//            $message = "УРААА";
            return $this->redirectToRoute('tickets');
        }
        $array = [
            'message' => $message,
            'form' => $form->createView(),
            'title' => 'Создать тикет ',
        ];
        return $this->render('ticket/add-ticket.html.twig',
            $array
        );
    }
    #[Route('/ticket/list', 'tickets')]
    public function ticketList() {
        $allOfuser = $this->entityManager->getRepository(TicketOfUser::class)->findBy(
            ['User' => $this->entityManager->getRepository(User::class)->findOneBy(
                ['username' => $this->getUser()->getUserIdentifier()])->getId()]);
        $ticketsOfUser = array();
        foreach ($allOfuser as $item) {
            $ticketsOfUser[] = $this->entityManager->getRepository(TicketEntity::class)->find($item->getTicket()->getId());
        }
        $array = [
            'ticketsOfUser' => $ticketsOfUser,
            'title' => 'Все тикеты тикеты пользователя'.$this->getUser()->getUserIdentifier(),
        ];
        return $this->render('ticket/list.html.twig',
            $array
        );
    }

    #[Route(path: '/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(Request $request): Response
    {
        $form = $this->publicForm->create(new User(), RegistrationFormType::class);
        $form->handleRequest($request);
        if ($this->getUser()) {
            return $this->redirectToRoute('tickets');
        }
        $array = [
            'form' => $form->createView(),
            'title' => 'Войти',
            'toWhere' => 'reg',
            'method' => 'POST'
        ];
        return $this->render('ticket/auth.html.twig', $array);
    }

    #[Route('/logout', name: "logout", methods: ['GET'])]
    public function logout(): int
    {
    }
}
