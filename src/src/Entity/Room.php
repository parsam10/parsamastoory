<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $bed_count;

    #[ORM\Column(type: 'boolean')]
    private $is_empty;

    #[ORM\ManyToOne(targetEntity: Hotel::class, inversedBy: 'rooms')]
    #[ORM\JoinColumn(nullable: false)]
    private $hotel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBedCount(): ?int
    {
        return $this->bed_count;
    }

    public function setBedCount(int $bed_count): self
    {
        $this->bed_count = $bed_count;

        return $this;
    }

    public function getIsEmpty(): ?bool
    {
        return $this->is_empty;
    }

    public function setIsEmpty(bool $is_empty): self
    {
        $this->is_empty = $is_empty;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }
}
