<?php


namespace App\Controller;

use App\Entity\Meal;
use App\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class MealController extends AbstractController
{
    #[Route("/restaurants/{id}/meals", methods: ["GET"])]
    public function listAction(int $id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Meal::class);
        $meals = $repo->findBy(
            ['restaurant' => $id]);
        if ($meals === null) {
            throw new NotFoundHttpException();
        }
        return $this->json($meals);
    }

    #[Route("/restaurants/{id}/meals", methods: ["POST"])]
    public function createAction(Request $request, int $id, ValidatorInterface $validator): Response
    {
        $data = $request->toArray();
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Restaurant::class);
        $rest = $repo->find($id);
        if ($rest === null) {
            throw new NotFoundHttpException();
        }
        $meal = new Meal($rest, $data["name"] ?? "", $data["price"] ?? "");
        $errors = $validator->validate($meal);

        if (count($errors) > 0) {


            return $this->json($errors, 400);
        }
        $entityManager->persist($meal);
        $entityManager->flush();

        return $this->json($meal);
    }

    #[Route("/restaurants/{id}/meals/{idMeal}", methods: ["GET"])]
    public function detailAction(int $id, int $idMeal): Response
    {
        $repo = $this->getDoctrine()->getRepository(Meal::class);
        $meal = $repo->findBy(['restaurant' => $id, 'id' => $idMeal]);
        if ($meal === null) {
            throw new NotFoundHttpException();
        }
        return $this->json($meal);
    }

    #[Route("/restaurants/{id}/meals/{idMeal}", methods: ["PUT"])]
    public function editAction(Request $request, int $id, int $idMeal, ValidatorInterface $validator): Response
    {
        $data = $request->toArray();
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Meal::class);
        $meal = $repo->findOneBy(['restaurant' => $id, 'id' => $idMeal]);
        if ($meal === null) {
            throw new NotFoundHttpException();
        }
        $meal->setName($data["name"]);
        $errors = $validator->validate($meal);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }
        $entityManager->flush();
        return $this->json($meal);
    }

    #[Route("/restaurants/{id}/meals/{idMeal}", methods: ["DELETE"])]
    public function deleteAction(int $id, int $idMeal, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Meal::class);
        $meal = $repo->findOneBy(
            ['restaurant' => $id,
                'id' => $idMeal]);
        if ($meal == null) {
            throw new NotFoundHttpException();
        }
        $entityManager->remove($meal);
        $entityManager->flush();
        $meal = $repo->findBy(
            ['restaurant' => $id]);
        return $this->json($meal);

    }

}