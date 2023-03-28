<?php

namespace App\Entity;

use App\Repository\TicketEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TicketEntityRepository::class)]
#[UniqueEntity('name')]
class TicketEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'ticketEntities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UrgencyEntity $urgency = null;

    #[ORM\ManyToOne(inversedBy: 'ticketEntities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    #[ORM\OneToMany(mappedBy: 'Ticket', targetEntity: TicketOfUser::class, orphanRemoval: true)]
    private Collection $ticketOfUsers;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->ticketOfUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getUrgency(): ?UrgencyEntity
    {
        return $this->urgency;
    }

    public function setUrgency(?UrgencyEntity $urgency): self
    {
        $this->urgency = $urgency;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, TicketOfUser>
     */
    public function getTicketOfUsers(): Collection
    {
        return $this->ticketOfUsers;
    }

    public function addTicketOfUser(TicketOfUser $ticketOfUser): self
    {
        if (!$this->ticketOfUsers->contains($ticketOfUser)) {
            $this->ticketOfUsers->add($ticketOfUser);
            $ticketOfUser->setTicket($this);
        }

        return $this;
    }

    public function removeTicketOfUser(TicketOfUser $ticketOfUser): self
    {
        if ($this->ticketOfUsers->removeElement($ticketOfUser)) {
            // set the owning side to null (unless already changed)
            if ($ticketOfUser->getTicket() === $this) {
                $ticketOfUser->setTicket(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

}
