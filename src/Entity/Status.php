<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: TicketEntity::class, orphanRemoval: true)]
    private Collection $ticketEntities;

    public function __construct()
    {
        $this->ticketEntities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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
            $ticketEntity->setStatus($this);
        }

        return $this;
    }

    public function removeTicketEntity(TicketEntity $ticketEntity): self
    {
        if ($this->ticketEntities->removeElement($ticketEntity)) {
            // set the owning side to null (unless already changed)
            if ($ticketEntity->getStatus() === $this) {
                $ticketEntity->setStatus(null);
            }
        }

        return $this;
    }
}
