<?php

namespace App\Entity;

use App\Repository\FavouriteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavouriteRepository::class)
 */
class Favourite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Property::class, inversedBy="favourites", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bien_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBienId(): ?Property
    {
        return $this->bien_id;
    }

    public function setBienId(?Property $bien_id): self
    {
        $this->bien_id = $bien_id;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
