<?php

namespace App\Controller;

use App\Entity\Attraction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class AttractionController extends AbstractController
{
    #[Route('/attraction', name: 'create_attraction')]
    public function createAttraction(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $attraction = new Attraction();
        $attraction->setName('TempName');
        $attraction->setShortDescription('Temp short description');
        $attraction->setFullDescription('Temp full description');
        $attraction->setScore(5);

        // tell Doctrine you want to (eventually) save the Attraction (no queries yet)
        $entityManager->persist($attraction);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new attraction with id ' . $attraction->getId());
    }

    #[Route("/attraction/{id}", name: "get_attraction")]
    public function get(Attraction $attraction): Response
    {
        return new Response('attraction name:' . $attraction->getName());
    }

    #[Route("/all_attraction", name: "get_all_attraction")]
    public function getAll(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Attraction::class);
        $allAttractions = $repository->findAll();
        $result = "";

        foreach ($allAttractions as $attraction) {
            $result .= $attraction->getName() . " with id " . $attraction->getId() . " \n";
        }

        return new Response('attractions names:' . $result);
    }

    /**
     * @Route("/attraction/edit/{id}")
     */
    public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $attraction = $entityManager->getRepository(Attraction::class)->find($id);

        if (!$attraction) {
            throw $this->createNotFoundException(
                'No attraction found for id ' . $id
            );
        }

        $attraction->setName('New attraction name!');
        $entityManager->flush();

        return $this->redirectToRoute('get_attraction', [
            'id' => $attraction->getId()
        ]);
    }

    #[Route("/attraction/delete/{id}", name: "delete_attraction")]
    public function delete(ManagerRegistry $doctrine, Attraction $attraction): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($attraction);
        $entityManager->flush();
        return new Response('attraction with name: ' . $attraction->getName() . " removed");
    }
}
