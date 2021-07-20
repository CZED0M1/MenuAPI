<?php

namespace App\Entity;

use App\Repository\MealOnMenuRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MealOnMenuRepository::class)
 */
class MealOnMenu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",unique=true)
     * @Groups("read")
     */
    private int $id;
    /**
     * @Groups({"rest"})
     * @ORM\ManyToOne(targetEntity=Menu::class, cascade={"all"},inversedBy= "meals")
    * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private Menu $menu;

    /**
     *  @Groups("read")
     * @ORM\ManyToOne(targetEntity=Meal::class, cascade={"all"})
     */
    private Meal $meal;

    /**
     *  @Groups("read")
     * @ORM\Column(type="integer")
     */
    private int $price;

    /**
     * MealOnMenu constructor.
     * @param Menu $menu
     * @param Meal $meal
     * @param int $price
     */
    public function __construct(Menu $menu, Meal $meal, int $price)
    {
        $this->menu = $menu;
        $this->meal = $meal;
        $this->price = $price;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeal(): Meal
    {
        return $this->meal;
    }

    public function setMeal(Meal $meal): self
    {
        $this->meal = $meal;

        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
