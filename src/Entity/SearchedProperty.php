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
     * @ORM\Column(type="integer")
     */
    private $minsurface;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $yes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $createdAt;

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

    public function getYes(): ?string
    {
        return $this->yes;
    }

    public function setYes(?string $yes): self
    {
        $this->yes = $yes;

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
}
