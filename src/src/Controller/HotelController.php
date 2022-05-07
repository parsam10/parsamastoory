<?php

namespace App\Controller;

use App\Entity\Hotel;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    #[Route('/hotel', name: 'create_hotel')]
    public function createHotel(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $hotel = new Hotel();
        $hotel->setName('TempName');
        $hotel->setAddress('Iran/Tehran');
        $hotel->setStarCount(5);

        // tell Doctrine you want to (eventually) save the Hotel (no queries yet)
        $entityManager->persist($hotel);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new hotel with id ' . $hotel->getId());
    }

    #[Route("/hotel/{id}", name: "get_hotel")]
    public function get(Hotel $hotel): Response
    {
        return new Response('hotel name:' . $hotel->getName());
    }

    #[Route("/all_hotel", name: "get_all_hotel")]
    public function getAll(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Hotel::class);
        $allHotels = $repository->findAll();
        $result = "";

        foreach ($allHotels as $hotel) {
            $result .= $hotel->getName() . " with id " . $hotel->getId() . " \n";
        }

        return new Response('hotels names:' . $result);
    }

    #[Route("/hotel/edit/{id}", name: "edit_hotel")]
    public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $hotel = $entityManager->getRepository(Hotel::class)->find($id);

        if (!$hotel) {
            throw $this->createNotFoundException(
                'No hotel found for id ' . $id
            );
        }

        $hotel->setName('New hotel name!');
        $entityManager->flush();

        return $this->redirectToRoute('get_hotel', [
            'id' => $hotel->getId()
        ]);
    }

    #[Route("/hotel/delete/{id}", name: "delete_hotel")]
    public function delete(ManagerRegistry $doctrine, Hotel $hotel): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($hotel);
        $entityManager->flush();
        return new Response('hotel with name: ' . $hotel->getName() . " removed");
    }
}