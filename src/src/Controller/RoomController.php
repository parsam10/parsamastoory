<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Room;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    #[Route('/room', name: 'create_room')]
    public function createRoom(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $hotel = new Hotel();
        $hotel->setName("RandHotel" . $hotel->getId());
        $hotel->setAddress("Karaj,");
        $hotel->setStarCount(mt_rand(0, 5));

        $room = new Room();
        $room->setBedCount(2);
        $room->setIsEmpty((bool)mt_rand(0, 1));
        $room->setHotel($hotel);

        $entityManager->persist($hotel);
        $entityManager->persist($room);

        $entityManager->flush();

        return new Response('Saved new room with id ' . $room->getId() . ' Saved new hotel with id ' . $hotel->getId());
    }

    #[Route("/room/{id}", name: "get_room")]
    public function get(Room $room): Response
    {
        return new Response('room name:' . $room->getId());
    }

    #[Route("/all_room", name: "get_all_room")]
    public function getAll(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Room::class);
        $allRooms = $repository->findAll();
        $result = "";

        foreach ($allRooms as $room) {
            $result .= $room->getName() . " with id " . $room->getId() . " \n";
        }

        return new Response('rooms names:' . $result);
    }

    #[Route("/room/edit/{id}", name: "edit_room")]
    public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $room = $entityManager->getRepository(Room::class)->find($id);

        if (!$room) {
            throw $this->createNotFoundException(
                'No room found for id ' . $id
            );
        }

        $room->setName('New room name!');
        $entityManager->flush();

        return $this->redirectToRoute('get_room', [
            'id' => $room->getId()
        ]);
    }

    #[Route("/room/delete/{id}", name: "delete_room")]
    public function delete(ManagerRegistry $doctrine, Room $room): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($room);
        $entityManager->flush();
        return new Response('room with name: ' . $room->getId() . " removed");
    }
}