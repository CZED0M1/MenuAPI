<?php

namespace App\Entity;
use App\Repository\MealRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass=MealRepository::class)
 */
class Meal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"a"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"a"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, cascade={"all"}, fetch="EAGER")
     */
    #[NotBlank]
    #[Length (max:255)]
    #[date]
    private $restaurant;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"a"})
     */
    private $price;


    public function __construct(Restaurant $restaurant, string $name, int $price)
    {
        $this->restaurant = $restaurant;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }










}
