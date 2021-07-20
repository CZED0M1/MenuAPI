<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("read")
     */
    private int $id;

    /**
     *@ORM\ManyToOne(targetEntity=Restaurant::class)
     * @Groups("read")
     */
    private Restaurant $restaurant;

    /**
     * @ORM\Column(type="date",unique=true)
     * @Groups("read")
     */
    private \DateTime $date;

    /**
     * @ORM\OneToMany(targetEntity=MealOnMenu::class, mappedBy= "menu")
     * @Groups("read")
     */
    private Collection $meals;

    /**
     * Menu constructor.
     * @param Restaurant $restaurant
     * @param \DateTime $date
     */
    public function __construct(Restaurant $restaurant, \DateTime $date)
    {
        $this->restaurant = $restaurant;
        $this->date = $date;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRestaurant(): Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getMeals(): Collection
    {
        return $this->meals;
    }



}
