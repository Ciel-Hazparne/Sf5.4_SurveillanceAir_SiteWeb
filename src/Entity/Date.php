<?php

namespace App\Entity;

use App\Repository\DateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DateRepository::class)
 */
class Date
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_min;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_max;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMin(): ?\DateTimeInterface
    {
        return $this->date_min;
    }

    public function setDateMin(\DateTimeInterface $date_min): self
    {
        $this->date_min = $date_min;

        return $this;
    }

    public function getDateMax(): ?\DateTimeInterface
    {
        return $this->date_max;
    }

    public function setDateMax(\DateTimeInterface $date_max): self
    {
        $this->date_max = $date_max;

        return $this;
    }
}
