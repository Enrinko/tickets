<?php

namespace App\Entity;

use App\Repository\TicketOfUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketOfUserRepository::class)]
class TicketOfUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ticketOfUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\ManyToOne(inversedBy: 'ticketOfUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TicketEntity $Ticket = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getTicket(): ?TicketEntity
    {
        return $this->Ticket;
    }

    public function setTicket(?TicketEntity $Ticket): self
    {
        $this->Ticket = $Ticket;

        return $this;
    }
}
