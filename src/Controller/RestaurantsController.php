<?php

namespace App\Controller;

use App\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RestaurantsController extends AbstractController
{

    #[Route("/restaurants", methods: ["GET"])]
    public function listAction(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Restaurant::class);
        $rest = $repo->findAll();
        return $this->json($rest);
    }

    #[Route("/restaurants/{id}", methods: ["GET"])]
    public function detailAction(int $id): Response
    {
        $rep = $this->getDoctrine()->getRepository(Restaurant::class);
        $rest = $rep->find($id);
        if ($rest === null) {
            throw new NotFoundHttpException();
        }
        return $this->json($rest);
    }

    #[Route("/restaurants", methods: ["POST"])]
    public function createAction(Request $request, ValidatorInterface $validator): Response
    {
        $data = $request->toArray();
        $entityManager = $this->getDoctrine()->getManager();
        $rest = new Restaurant();
        $rest->setName($data["name"] ?? "");
        $rest->setUrl($data["url"] ?? "");

        $errors = $validator->validate($rest);

        if (count($errors) > 0) {


            return $this->json($errors, 400);
        }
        $entityManager->persist($rest);

        $entityManager->flush();

        return $this->json($rest);
    }

    #[Route("/restaurants/{id}", methods: ["DELETE"])]
    public function deleteAction(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $repo = $this->getDoctrine()->getRepository(Restaurant::class);
        $rest = $repo->find($id);
        if ($rest === null) {
            throw new NotFoundHttpException();
        }
        $entityManager->remove($rest);
        $entityManager->flush();
        $rest = $repo->findall();
        return $this->json($rest);
    }

    #[Route("/restaurants/{id}", methods: ["PUT"])]
    public function editAction(Request $request, int $id, ValidatorInterface $validator): Response
    {
        $data = $request->toArray();
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Restaurant::class);
        $rest = $repo->find($id);
        if ($rest === null) {
            throw new NotFoundHttpException();
        }
        $rest->setName($data["name"] ?? "");
        $errors = $validator->validate($rest);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }
        $entityManager->flush();
        return $this->json($rest);
    }
}
