<?php


namespace App\Controller;

use App\Entity\Meal;
use App\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractController
{
    /**
     * @Route("/restaurant/{id}")
     */
    public function hello(int $id): Response
    {
        $rep = $this->getDoctrine()->getRepository(Restaurant::class);
        $rest = $rep->find($id);
        dd($rest);

       // return $this->json($rest);
    }
    public function helloNo(): Response {
        $repo = $this->getDoctrine()->getRepository(Meal::class);
        $meal = $repo->findAll();
            return $this->json($meal);
    }
}