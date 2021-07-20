<?php


namespace App\MenuOutput;


use App\Entity\MealOnMenu;
use App\Entity\Menu;

class MenuOutput
{
    public array $meals;

    public function __construct(Menu $menu)
    {
        $this->meals = array_map(function (MealOnMenu $meal) {
            return [
                'name' => $meal->getMeal()->getName(),
                'price' => $meal->getPrice()
            ];
        }, $menu->getMeals()->toArray());
    }



}