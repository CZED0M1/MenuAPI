<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *  * @ORM\ManyToOne(targetEntity=Restaurant::class, cascade={"all"}, fetch="EAGER")
     */
    private $restaurant;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="object", nullable=true)
     */
    private $meals;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRestaurant(): ?string
    {
        return $this->restaurant;
    }

    public function setRestaurant(?string $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMeals()
    {
        return $this->meals;
    }

    public function setMeals($meals): self
    {
        $this->meals = $meals;

        return $this;
    }
}
