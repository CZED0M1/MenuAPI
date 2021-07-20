<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Restaurant;
use App\MenuOutput\MenuOutput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{


    #[Route("/restaurant/{restId}/menu/{date}", methods: ["GET"])]
    public function listAction(int $restId, \DateTime $date): Response
    {
        $repo = $this->getDoctrine()->getRepository(Menu::class);
        $menu = $repo->findOneBy(['restaurant' => $restId,
            'date' => $date]);
        return $this->json($menu, context: ['groups' => 'read']);
    }

    #[Route("/restaurant/menu/{restName}/{date}", methods: ["GET"])]
    public function EasyListAction(string $restName, \DateTime $date): Response
    {
        $repo = $this->getDoctrine()->getRepository(Menu::class);


        $restRepo = $this->getDoctrine()->getRepository(Restaurant::class);
        $restaurant = $restRepo->findBy(['name' => $restName]);
        if ($restaurant === array()) {
            throw new NotFoundHttpException("Restaurace");
        }
        /** @var Menu $menu */
        $menu = $repo->findOneBy([
            'restaurant' => $restaurant,
            'date' => $date]);
        if ($menu === null) {
            throw new NotFoundHttpException("Menu");
        }
        $output = new MenuOutput($menu);
        return $this->json($output);
    }

}
