<?php

namespace App\Entity;

use App\Repository\SearchedPropertyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SearchedPropertyRepository::class)
 */
class SearchedProperty
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minprice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxprice;

    /**
     * @ORM\Column(type="integer", nullable=true )
     */
    private $minsurface;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxsurface;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMinprice(): ?int
    {
        return $this->minprice;
    }

    public function setMinprice(?int $minprice): self
    {
        $this->minprice = $minprice;

        return $this;
    }

    public function getMaxprice(): ?int
    {
        return $this->maxprice;
    }

    public function setMaxprice(?int $maxprice): self
    {
        $this->maxprice = $maxprice;

        return $this;
    }

    public function getMinsurface(): ?int
    {
        return $this->minsurface;
    }

    public function setMinsurface(int $minsurface): self
    {
        $this->minsurface = $minsurface;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getMaxsurface(): ?int
    {
        return $this->maxsurface;
    }

    public function setMaxsurface(?int $maxsurface): self
    {
        $this->maxsurface = $maxsurface;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
