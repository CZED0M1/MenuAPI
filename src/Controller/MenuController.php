<?php

namespace App\Controller;

use App\Entity\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route("/menu/{id}", methods: ["GET"])]
    public function listAction($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Menu::class);
        $meals = $repo->find($id);
        return $this->json($meals);
    }
}
