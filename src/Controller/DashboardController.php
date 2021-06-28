<?php


namespace App\Controller;

use App\Entity\Meal;
use Doctrine\ORM\Query\AST\Functions\AbsFunction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard/{id}")
     */
    public function hello(int $id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Meal::class);
        $meal = $repo->find($id);
        return $this->json($meal);
    }

}