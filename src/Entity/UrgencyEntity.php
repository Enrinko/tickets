<?php

namespace App\Entity;

use App\Repository\UrgencyEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UrgencyEntityRepository::class)]
class UrgencyEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $time = null;

    #[ORM\OneToMany(mappedBy: 'urgency', targetEntity: TicketEntity::class, orphanRemoval: true)]
    private Collection $ticketEntities;

    public function __construct()
    {
        $this->ticketEntities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return Collection<int, TicketEntity>
     */
    public function getTicketEntities(): Collection
    {
        return $this->ticketEntities;
    }

    public function addTicketEntity(TicketEntity $ticketEntity): self
    {
        if (!$this->ticketEntities->contains($ticketEntity)) {
            $this->ticketEntities->add($ticketEntity);
            $ticketEntity->setUrgency($this);
        }

        return $this;
    }

    public function removeTicketEntity(TicketEntity $ticketEntity): self
    {
        if ($this->ticketEntities->removeElement($ticketEntity)) {
            // set the owning side to null (unless already changed)
            if ($ticketEntity->getUrgency() === $this) {
                $ticketEntity->setUrgency(null);
            }
        }

        return $this;
    }
}
